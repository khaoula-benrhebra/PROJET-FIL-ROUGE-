<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationRepository extends BaseRepository
{
    public function __construct(Reservation $model)
    {
        parent::__construct($model);
    }
    
   
    public function getReservationsByRestaurant($restaurantId)
    {
        return $this->model->where('restaurant_id', $restaurantId)
            ->with(['user', 'tables', 'meals'])
            ->orderBy('reservation_datetime', 'desc')
            ->get();
    }
    
   
    public function getReservationsByRestaurantAndDate($restaurantId, Carbon $date)
    {
        return $this->model->where('restaurant_id', $restaurantId)
            ->whereDate('reservation_datetime', $date->toDateString())
            ->with(['user', 'tables', 'meals'])
            ->get();
    }
    
  
    public function getReservationsByCurrentUser()
    {
        return $this->model->where('user_id', Auth::id())
            ->with(['restaurant', 'tables', 'meals'])
            ->orderBy('reservation_datetime', 'desc')
            ->get();
    }


    public function getAvailableTables($restaurantId, $reservationDatetime, $guests)
    {
        $tables = DB::table('tables')
            ->where('restaurant_id', $restaurantId)
            ->where('is_available', true)
            ->get();
        
        if ($tables->isEmpty()) {
            return collect([]);
        }
        
       
        $reservationStart = $reservationDatetime->copy();
        $reservationEnd = $reservationDatetime->copy()->addHours(2);
        
        if ($reservationStart->isPast()) {
            return collect([]);
        }
        
      
        $overlappingReservations = $this->model
            ->where('restaurant_id', $restaurantId)
            ->where('status', '!=', 'canceled')
            ->where(function ($query) use ($reservationStart, $reservationEnd) {
                $query->where(function ($q) use ($reservationStart, $reservationEnd) {
                    $q->where('reservation_datetime', '>=', $reservationStart)
                      ->where('reservation_datetime', '<', $reservationEnd);
                })
                ->orWhere(function ($q) use ($reservationStart) {
                    $q->where('reservation_datetime', '<', $reservationStart)
                      ->whereRaw('DATE_ADD(reservation_datetime, INTERVAL 2 HOUR) > ?', [$reservationStart]);
                });
            })
            ->with(['tables'])
            ->get();
        
        
        $reservedTableIds = collect([]);
        foreach ($overlappingReservations as $reservation) {
            $reservedTableIds = $reservedTableIds->merge($reservation->tables->pluck('id'));
        }
        
        
        $availableTables = collect($tables)->filter(function ($table) use ($reservedTableIds) {
            return !$reservedTableIds->contains($table->id);
        });
        
        return $availableTables;
    }
    
    public function createReservation(array $data)
    {
        DB::beginTransaction();
        
        try {
          
            if (empty($data['name']) || empty($data['email']) || empty($data['guests']) || 
                empty($data['reservation_datetime']) || empty($data['tables'])) {
                throw new \Exception('Toutes les informations requises doivent être fournies.');
            }

           
            $availableTables = $this->getAvailableTables(
                $data['restaurant_id'],
                Carbon::parse($data['reservation_datetime']),
                $data['guests']
            );

            if ($availableTables->isEmpty()) {
                throw new \Exception('Aucune table disponible pour cette réservation.');
            }

         
            $requestedTableIds = collect($data['tables']);
            $availableTableIds = $availableTables->pluck('id');
            
            if (!$requestedTableIds->every(function ($tableId) use ($availableTableIds) {
                return $availableTableIds->contains($tableId);
            })) {
                throw new \Exception('Certaines tables demandées ne sont pas disponibles.');
            }
            
            $reservation = $this->model->create([
                'user_id' => Auth::id(),
                'restaurant_id' => $data['restaurant_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'guests' => $data['guests'],
                'reservation_datetime' => Carbon::parse($data['reservation_datetime']),
                'special_requests' => $data['special_requests'] ?? null,
                'total_amount' => $data['total_amount'] ?? 0,
                'status' => 'confirmed' 
            ]);
            
            if (isset($data['tables']) && is_array($data['tables'])) {
                $reservation->tables()->attach($data['tables']);
            }
            
            if (isset($data['meals']) && is_array($data['meals'])) {
                foreach ($data['meals'] as $mealId => $mealData) {
                    if (isset($mealData['quantity']) && $mealData['quantity'] > 0) {
                        $reservation->meals()->attach($mealId, [
                            'quantity' => $mealData['quantity'],
                            'unit_price' => $mealData['price']
                        ]);
                    }
                }
            }
            
            DB::commit();
            return $reservation;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getDailyStatistics($restaurantId, $date)
    {
        return Reservation::where('restaurant_id', $restaurantId)
            ->whereDate('reservation_datetime', $date)
            ->select(
                DB::raw('COUNT(*) as reservations_count'),
                DB::raw('SUM(guests) as total_guests'),
                DB::raw('SUM(total_amount) as daily_revenue')
            )
            ->first();
    }
}