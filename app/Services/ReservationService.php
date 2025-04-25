<?php

namespace App\Services;

use App\Repositories\ReservationRepository;
use App\Models\Restaurant;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    protected $reservationRepository;
    
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }
   
    public function getRestaurantById($id)
    {
        return Restaurant::findOrFail($id);
    }
    
 
    public function createReservation(array $data)
    {
        if (isset($data['reservation_date']) && isset($data['reservation_time'])) {
            $data['reservation_datetime'] = Carbon::createFromFormat('d/m/Y H:i', $data['reservation_date'] . ' ' . $data['reservation_time']);
        }
        
        $totalAmount = 0;
        if (isset($data['meals']) && is_array($data['meals'])) {
            foreach ($data['meals'] as $mealData) {
                if (isset($mealData['quantity']) && $mealData['quantity'] > 0 && isset($mealData['price'])) {
                    $totalAmount += $mealData['quantity'] * $mealData['price'];
                }
            }
        }
        
        $data['total_amount'] = $totalAmount;
        $data['user_id'] = Auth::id();
        
        return $this->reservationRepository->createReservation($data);
    }

    public function getAvailableTables($restaurantId, $reservationDatetime, $guests)
    {
        $restaurant = Restaurant::with('tables')->findOrFail($restaurantId);
        
        if (!$restaurant) {
            throw new \Exception('Restaurant non trouvé.');
        }
        
        if ($restaurant->tables->isEmpty()) {
            throw new \Exception('Ce restaurant n\'a pas encore de tables configurées.');
        }
        
        try {
            $availableTables = $this->reservationRepository->getAvailableTables(
                $restaurantId, 
                $reservationDatetime,
                $guests
            );
        } catch (\Exception $e) {
            throw new \Exception('Erreur lors de la recherche de tables: ' . $e->getMessage());
        }
        
        if (is_null($availableTables) || (is_object($availableTables) && $availableTables->isEmpty()) || (is_array($availableTables) && empty($availableTables))) {
            return [];
        }
        
        $defaultCapacity = $restaurant->seats_per_table ?? 4;
        
        $availableTablesCollection = collect($availableTables);
        
        return $availableTablesCollection->map(function ($table) use ($defaultCapacity) {
            return [
                'id' => $table->id,
                'table_label' => $table->table_label,
                'capacity' => $defaultCapacity, 
                'shape' => 'rectangle' 
            ];
        })->values()->all();
    }

    public function getBookedDatesList($restaurantId, $openingTime = '10:00', $closingTime = '22:00')
    {
        $restaurant = Restaurant::with(['tables', 'reservations' => function($query) {
            $query->where('status', '!=', 'canceled');
        }])->findOrFail($restaurantId);
        
        if (!$restaurant) {
            throw new \Exception('Restaurant non trouvé.');
        }
        
        $totalTables = $restaurant->tables->count();
        
        if ($totalTables === 0) {
            return [
                'fullyBookedDates' => [],
                'bookedTimeSlots' => []
            ];
        }
        
        $reservations = $restaurant->reservations()
            ->where('status', '!=', 'canceled')
            ->where('reservation_datetime', '>=', Carbon::now())
            ->get();
        
        $reservationsByDate = [];
        $fullyBookedDates = [];
        $bookedTimeSlots = [];
        
        $openingHour = (int)substr($openingTime, 0, 2);
        $openingMinute = (int)substr($openingTime, 3, 2);
        $closingHour = (int)substr($closingTime, 0, 2);
        $closingMinute = (int)substr($closingTime, 3, 2);
        
        $startTime = Carbon::today()->setHour($openingHour)->setMinute($openingMinute);
        $endTime = Carbon::today()->setHour($closingHour)->setMinute($closingMinute);
        
        $timeSlots = [];
        $currentTime = clone $startTime;
        
        while ($currentTime <= $endTime) {
            $timeSlots[] = $currentTime->format('H:i');
            $currentTime->addMinutes(30);
        }
        
        foreach ($reservations as $reservation) {
            $date = $reservation->reservation_datetime->format('d/m/Y');
            $time = $reservation->reservation_datetime->format('H:i');
            
            if (!isset($reservationsByDate[$date])) {
                $reservationsByDate[$date] = [];
            }
            
            $reservationTime = Carbon::createFromFormat('H:i', $time);
            $reservationEndTime = (clone $reservationTime)->addHours(2);
            
            $currentSlot = clone $reservationTime;
            
            while ($currentSlot < $reservationEndTime) {
                $slotTime = $currentSlot->format('H:i');
                
                if (!isset($reservationsByDate[$date][$slotTime])) {
                    $reservationsByDate[$date][$slotTime] = 0;
                }
                
                $reservationsByDate[$date][$slotTime] += $reservation->tables->count();
                
                $currentSlot->addMinutes(30);
            }
        }
        
        foreach ($reservationsByDate as $date => $timeslots) {
            $allSlotsBooked = true;
            $dateBookedSlots = [];
            
            foreach ($timeSlots as $slot) {
                $tablesBooked = isset($timeslots[$slot]) ? $timeslots[$slot] : 0;
                $percentageBooked = ($tablesBooked / $totalTables) * 100;
                
                if ($percentageBooked >= 90) {
                    $dateBookedSlots[] = $slot;
                } else {
                    $allSlotsBooked = false;
                }
            }
            
            if ($allSlotsBooked) {
                $fullyBookedDates[] = $date;
            } elseif (!empty($dateBookedSlots)) {
                $bookedTimeSlots[$date] = $dateBookedSlots;
            }
        }
        
        return [
            'fullyBookedDates' => $fullyBookedDates,
            'bookedTimeSlots' => $bookedTimeSlots
        ];
    }

    public function getReservationsByRestaurant($restaurantId)
    {
        return $this->reservationRepository->getReservationsByRestaurant($restaurantId);
    }
    
    public function getReservationsByRestaurantAndDate($restaurantId, $date)
    {
        return $this->reservationRepository->getReservationsByRestaurantAndDate($restaurantId, $date);
    }

    public function getReservationsByUser()
    {
        return $this->reservationRepository->getReservationsByCurrentUser();
    }
}
