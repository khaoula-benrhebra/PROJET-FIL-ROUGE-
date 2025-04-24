<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReservationRequest;
use App\Services\ReservationService;
use App\Services\RestaurantService;
use App\Services\MealService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

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
                ->with('success', 'Votre réservation a été enregistrée avec succès et est en attente de confirmation.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function getAvailableTables(Request $request)
    {
        try {
            $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id',
                'reservation_date' => 'required|string',
                'reservation_time' => 'required|string',
                'guests' => 'required|integer|min:1'
            ]);
            
            $dateString = $request->reservation_date;
            $timeString = $request->reservation_time;
            
            $dateParts = explode('/', $dateString);
            if (count($dateParts) !== 3) {
                throw new \InvalidArgumentException('Format de date invalide. Utilisez JJ/MM/AAAA pour la date.');
            }
            
            $timeParts = explode(':', $timeString);
            if (count($timeParts) !== 2) {
                throw new \InvalidArgumentException('Format d\'heure invalide. Utilisez HH:MM pour l\'heure.');
            }
            
            try {
                $reservationDateTime = Carbon::create(
                    intval($dateParts[2]), // année
                    intval($dateParts[1]), // mois
                    intval($dateParts[0]), // jour
                    intval($timeParts[0]), // heure
                    intval($timeParts[1])  // minute
                );
                
                if (!$reservationDateTime) {
                    throw new \InvalidArgumentException('Date ou heure invalide.');
                }
            } catch (\Exception $e) {
                throw new \InvalidArgumentException('Date ou heure invalide. Veuillez vérifier le format.');
            }
            
            $now = Carbon::now();
            if ($reservationDateTime->lessThan($now)) {
                throw new \InvalidArgumentException('La date et l\'heure de réservation doivent être dans le futur.');
            }
            
            $hour = intval($timeParts[0]);
            if ($hour < 10 || $hour >= 22) {
                throw new \InvalidArgumentException('Les réservations sont possibles uniquement entre 10h00 et 22h00.');
            }
            
            $availableTables = $this->reservationService->getAvailableTables(
                $request->restaurant_id,
                $reservationDateTime,
                $request->guests
            );
            
            if (empty($availableTables)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucune table disponible pour cette date et heure.'
                ], 200);
            }
            
            return response()->json([
                'success' => true,
                'tables' => $availableTables
            ], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->handleValidationException($e);
        } catch (\InvalidArgumentException $e) {
            return $this->handleInvalidArgumentException($e);
        } catch (\Exception $e) {
            return $this->handleGeneralException($e);
        }
    }

   
    private function handleValidationException(\Illuminate\Validation\ValidationException $e)
    {
        return response()->json([
            'success' => false,
            'message' => 'Données de réservation invalides.',
            'errors' => $e->errors()
        ], 422);
    }
    private function handleInvalidArgumentException(\InvalidArgumentException $e)
    {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 400);
    }

    private function handleGeneralException(\Exception $e)
    {
        $errorMessage = sprintf(
            "Erreur de réservation - Date: %s, Message: %s, Fichier: %s, Ligne: %d",
            date('Y-m-d H:i:s'),
            $e->getMessage(),
            $e->getFile(),
            $e->getLine()
        );
        
        \Illuminate\Support\Facades\Log::channel('reservations')->error($errorMessage);
        
        return response()->json([
            'success' => false,
            'message' => 'Une erreur est survenue lors de la recherche des tables disponibles.'
        ], 500);
    }

    public function getBookedDates(Request $request)
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
    
   
    public function cancel($id)
    {
        try {
            $this->reservationService->cancelReservation($id);
            
            return redirect()->route('client.profile')
                ->with('success', 'Votre réservation a été annulée avec succès.');
                
        } catch (\Exception $e) {
            return redirect()->route('client.profile')
                ->with('error', $e->getMessage());
        }
    }
}