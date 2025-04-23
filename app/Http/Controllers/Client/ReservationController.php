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
    
    /**
     * Affiche le formulaire de réservation pour un restaurant spécifique
     */
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
            
            // Récupérer les repas de tous les menus du restaurant
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
    
    /**
     * Enregistre une nouvelle réservation
     */
    public function store(CreateReservationRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Vérifier que l'utilisateur est connecté
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Vous devez être connecté pour effectuer une réservation.')
                    ->with('redirect', route('client.reservations.create', ['restaurant_id' => $validated['restaurant_id']]));
            }
            
            // Créer la réservation en incluant une durée de 2 heures
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
    
    /**
     * Récupère les tables disponibles pour un restaurant à une date et heure spécifiques
     */
    public function getAvailableTables(Request $request)
    {
        try {
            $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id',
                'reservation_date' => 'required|date_format:d/m/Y',
                'reservation_time' => 'required|date_format:H:i',
                'guests' => 'required|integer|min:1'
            ]);
            
            // Formater la date et l'heure pour la requête
            $reservationDateTime = Carbon::createFromFormat('d/m/Y H:i', $request->reservation_date . ' ' . $request->reservation_time);
            
            $availableTables = $this->reservationService->getAvailableTables(
                $request->restaurant_id,
                $reservationDateTime,
                $request->guests
            );
            
            return response()->json([
                'success' => true,
                'tables' => $availableTables
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
    /**
     * Récupère les dates où toutes les tables sont réservées
     */
    public function getBookedDates(Request $request)
    {
        try {
            $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id'
            ]);
            
            // Récupérer les heures d'ouverture et de fermeture du restaurant
            $restaurant = $this->restaurantService->getRestaurantById($request->restaurant_id);
            $openingTime = "10:00"; // Par défaut 10h
            $closingTime = "22:00"; // Par défaut 22h
            
            // Récupérer les dates entièrement réservées et les créneaux réservés
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
    
    /**
     * Annule une réservation existante
     */
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