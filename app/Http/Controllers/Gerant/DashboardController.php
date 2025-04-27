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
        $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
        $date = $request->input('date', \Carbon\Carbon::today()->format('Y-m-d'));
        if (!$restaurant) {
            return view('pages.gerant.dashboard', compact('date'))->with('error', 'Vous n\'avez pas encore créé de restaurant.');
        }
        
        $filterDate = Carbon::parse($date);
        
        $allReservations = $this->reservationService->getReservationsByRestaurantAndDate($restaurant->id, $filterDate)
            ->load(['tables']);
        
        $dailyStats = $this->reservationService->getDailyStatistics($restaurant->id, $filterDate);
        
        $todayReservationsCount = $dailyStats->reservations_count ?? 0;
        $expectedGuestsCount = $dailyStats->total_guests ?? 0;
        $dailyRevenue = $dailyStats->daily_revenue ?? 0;
        
        return view('pages.gerant.dashboard', compact(
            'allReservations', 
            'todayReservationsCount', 
            'expectedGuestsCount',
            'dailyRevenue',
            'date'
        ));
    }
}