<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Services\ReservationService;
use App\Services\RestaurantService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $reservationService;
    protected $restaurantService;
    
    public function __construct(
        ReservationService $reservationService,
        RestaurantService $restaurantService
    ) {
        $this->middleware('auth');
        $this->reservationService = $reservationService;
        $this->restaurantService = $restaurantService;
    }
    
    public function index(Request $request)
    {
        // Récupérer le restaurant du gérant
        $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
        if (!$restaurant) {
            return view('pages.gerant.dashboard')->with('error', 'Vous n\'avez pas encore créé de restaurant.');
        }
        
        // Récupérer les réservations (toutes, pas seulement les 5 dernières)
        $allReservations = $this->reservationService->getReservationsByRestaurant($restaurant->id);
        
        // Filtrer par statut si spécifié dans la requête
        $status = $request->input('status');
        if ($status && $status !== 'all') {
            $allReservations = $allReservations->filter(function($reservation) use ($status) {
                return $reservation->status === $status;
            });
        }
        
        // Filtrer par date si spécifié dans la requête
        $date = $request->input('date');
        if ($date) {
            $filterDate = Carbon::parse($date);
            $allReservations = $allReservations->filter(function($reservation) use ($filterDate) {
                return $reservation->reservation_datetime->isSameDay($filterDate);
            });
        }
        
        // Récupérer les 5 dernières réservations pour l'affichage initial
        $recentReservations = $allReservations->take(5);
        
        // Statistiques du jour
        $today = Carbon::today();
        $todayReservations = $this->reservationService->getReservationsByRestaurantAndDate($restaurant->id, $today);
        
        $todayReservationsCount = $todayReservations->count();
        $expectedGuestsCount = $todayReservations->sum('guests');
        
        // Compter les tables occupées
        $occupiedTablesCount = 0;
        foreach ($todayReservations as $reservation) {
            $occupiedTablesCount += $reservation->tables->count();
        }
        
        // Calculer le revenu journalier
        $dailyRevenue = $todayReservations->sum('total_amount');
        
        return view('pages.gerant.dashboard', compact(
            'recentReservations',
            'allReservations', 
            'todayReservationsCount', 
            'expectedGuestsCount',
            'occupiedTablesCount',
            'dailyRevenue'
        ));
    }
    
    /**
     * Met à jour le statut d'une réservation via AJAX
     */
    public function updateReservationStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,confirmed,canceled,completed'
            ]);
            
            $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
            
            if (!$restaurant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Restaurant non trouvé.'
                ], 404);
            }
            
            $reservation = $this->reservationService->updateReservationStatus($id, $request->status);
            
            return response()->json([
                'success' => true,
                'message' => 'Statut de la réservation mis à jour avec succès.',
                'reservation' => $reservation
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}