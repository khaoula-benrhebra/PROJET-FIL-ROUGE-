<?php

namespace App\Http\Controllers\Client;

use Log;
use Carbon\Carbon;
use PHPUnit\Util\Exception;
use Illuminate\Http\Request;
use App\Services\MealService;
use App\Services\RestaurantService;
use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateReservationRequest;

class ReservationController extends Controller
{
    protected $reservationService;
    protected $restaurantService;
    protected $mealService;
    
    public function __construct(
        ReservationService $reservationService,
        RestaurantService $restaurantService,
        MealService $mealService
    ) {
        $this->middleware('auth');
        $this->reservationService = $reservationService;
        $this->restaurantService = $restaurantService;
        $this->mealService = $mealService;
    }

    public function create(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        
        if (!$restaurantId) {
            return redirect()->route('restaurants')
                ->with('error', 'Veuillez sélectionner un restaurant pour effectuer une réservation.');
        }
        
        try {
            $restaurant = $this->restaurantService->getRestaurantById($restaurantId);
            
            if (!$restaurant) {
                return redirect()->route('restaurants')
                    ->with('error', 'Restaurant non trouvé.');
            }
            
            $menus = $restaurant->menus;
            $meals = [];
            
            foreach ($menus as $menu) {
                $menuMeals = $menu->meals;
                foreach ($menuMeals as $meal) {
                    $meals[] = $meal;
                }
            }
            
            return view('pages.reservation', compact('restaurant', 'meals'));
            
        } catch (\Exception $e) {
            return redirect()->route('restaurants')
                ->with('error', $e->getMessage());
        }
    }
    
   
    public function store(CreateReservationRequest $request)
    {
        try {
            $validated = $request->validated();
            
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Vous devez être connecté pour effectuer une réservation.')
                    ->with('redirect', route('client.reservations.create', ['restaurant_id' => $validated['restaurant_id']]));
            }
            
            $reservationDateTime = Carbon::createFromFormat('d/m/Y H:i', $validated['reservation_date'] . ' ' . $validated['reservation_time']);
            $validated['reservation_datetime'] = $reservationDateTime;
            
            $reservation = $this->reservationService->createReservation($validated);
            
            return redirect()->route('client.profile')
                ->with('success', 'Votre réservation a été confirmée avec succès.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function getAvailableTables(Request $request)
    {
        // 1. Validation des données de base
        if (!$request->restaurant_id || !$request->reservation_date || !$request->reservation_time || !$request->guests) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez remplir tous les champs requis.'
            ], 400);
        }

        // 2. Vérification du format de la date
        $dateParts = explode('/', $request->reservation_date);
        if (count($dateParts) !== 3) {
            return response()->json([
                'success' => false,
                'message' => 'La date doit être au format JJ/MM/AAAA'
            ], 400);
        }

        // 3. Vérification du format de l'heure
        $timeParts = explode(':', $request->reservation_time);
        if (count($timeParts) !== 2) {
            return response()->json([
                'success' => false,
                'message' => 'L\'heure doit être au format HH:MM'
            ], 400);
        }

        try {
            // 4. Création de la date et heure de réservation
            $reservationDateTime = Carbon::create(
                intval($dateParts[2]), // année
                intval($dateParts[1]), // mois
                intval($dateParts[0]), // jour
                intval($timeParts[0]), // heure
                intval($timeParts[1])  // minute
            );

            // 5. Vérification si la date est dans le passé
            if ($reservationDateTime->isPast()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vous ne pouvez pas réserver dans le passé'
                ], 400);
            }

            // 6. Vérification des heures d'ouverture
            $heure = intval($timeParts[0]);
            if ($heure < 10 || $heure >= 22) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le restaurant est ouvert de 10h00 à 22h00'
                ], 400);
            }

            // 7. Recherche des tables disponibles
            $tables = $this->reservationService->getAvailableTables(
                $request->restaurant_id,
                $reservationDateTime,
                $request->guests
            );

            // 8. Vérification si des tables sont disponibles
            if (empty($tables)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Désolé, aucune table n\'est disponible pour cette date et heure'
                ], 200);
            }

            // 9. Retour des tables disponibles
            return response()->json([
                'success' => true,
                'tables' => $tables
            ], 200);

        } catch (Exception $erreur) {
            // En cas d'erreur, on retourne un message simple
            return response()->json([
                'success' => false,
                'message' => 'Désolé, une erreur est survenue. Veuillez réessayer.'
            ], 500);
        }
    }

    public function getBookedDatesList($request)
    {
        try {
            $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id'
            ]);
            
            $restaurant = $this->restaurantService->getRestaurantById($request->restaurant_id);
            $openingTime = "10:00"; 
            $closingTime = "22:00";
            
            $bookingData = $this->reservationService->getBookedDatesList(
                $request->restaurant_id,
                $openingTime,
                $closingTime
            );
            
            return response()->json([
                'success' => true,
                'fullyBookedDates' => $bookingData['fullyBookedDates'],
                'bookedTimeSlots' => $bookingData['bookedTimeSlots']
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getReservationsByUser()
    {
        return $this->reservationService->getReservationsByUser();
    }
}