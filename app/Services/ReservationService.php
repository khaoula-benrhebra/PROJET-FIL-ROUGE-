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
    
    /**
     * Récupère un restaurant par son ID
     */
    public function getRestaurantById($id)
    {
        return Restaurant::findOrFail($id);
    }
    
    /**
     * Crée une nouvelle réservation
     */
    public function createReservation(array $data)
    {
        // Formater la date et l'heure
        if (isset($data['reservation_date']) && isset($data['reservation_time'])) {
            $data['reservation_datetime'] = Carbon::createFromFormat('d/m/Y H:i', $data['reservation_date'] . ' ' . $data['reservation_time']);
        }
        
        // Calculer le montant total des repas
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
    
    /**
     * Récupère les tables disponibles à une date et heure spécifiques
     */
    public function getAvailableTables($restaurantId, $reservationDatetime, $guests)
    {
        // Obtenir toutes les tables du restaurant
        $restaurant = Restaurant::with('tables')->findOrFail($restaurantId);
        
        if (!$restaurant) {
            throw new \Exception('Restaurant non trouvé.');
        }
        
        // Vérifier si les tables sont disponibles à cette date/heure
        $availableTables = $this->reservationRepository->getAvailableTables(
            $restaurantId, 
            $reservationDatetime,
            $guests
        );
        
        // Si aucune table n'est disponible
        if ($availableTables->isEmpty()) {
            return [];
        }
        
        // Renvoyer les tables disponibles avec toutes les informations nécessaires
        return $availableTables->map(function ($table) {
            return [
                'id' => $table->id,
                'table_label' => $table->table_label,
                'capacity' => $table->capacity ?? 4, // Valeur par défaut de 4 si non définie
                'shape' => $table->shape ?? 'rectangle',
            ];
        })->toArray();
    }
    
    /**
     * Récupère la liste des dates et heures réservées pour un restaurant
     */
    public function getBookedDatesList($restaurantId, $openingTime = '10:00', $closingTime = '22:00')
    {
        $restaurant = Restaurant::with(['tables', 'reservations' => function($query) {
            $query->where('status', '!=', 'canceled');
        }])->findOrFail($restaurantId);
        
        if (!$restaurant) {
            throw new \Exception('Restaurant non trouvé.');
        }
        
        // Nombre total de tables du restaurant
        $totalTables = $restaurant->tables->count();
        
        if ($totalTables === 0) {
            return [
                'fullyBookedDates' => [],
                'bookedTimeSlots' => []
            ];
        }
        
        // Récupérer toutes les réservations non annulées pour ce restaurant
        $reservations = $restaurant->reservations()
            ->where('status', '!=', 'canceled')
            ->where('reservation_datetime', '>=', Carbon::now())
            ->get();
        
        // Organiser les réservations par date et heure
        $reservationsByDate = [];
        $fullyBookedDates = [];
        $bookedTimeSlots = [];
        
        // Créer des plages horaires de 30 minutes, de l'ouverture à la fermeture
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
        
        // Regrouper les réservations par date
        foreach ($reservations as $reservation) {
            $date = $reservation->reservation_datetime->format('d/m/Y');
            $time = $reservation->reservation_datetime->format('H:i');
            
            if (!isset($reservationsByDate[$date])) {
                $reservationsByDate[$date] = [];
            }
            
            // Pour chaque réservation, bloquer un créneau de 2 heures
            $reservationTime = Carbon::createFromFormat('H:i', $time);
            $reservationEndTime = (clone $reservationTime)->addHours(2);
            
            // Compter les tables réservées pour chaque créneau de 30 minutes pendant 2 heures
            $currentSlot = clone $reservationTime;
            
            while ($currentSlot < $reservationEndTime) {
                $slotTime = $currentSlot->format('H:i');
                
                if (!isset($reservationsByDate[$date][$slotTime])) {
                    $reservationsByDate[$date][$slotTime] = 0;
                }
                
                // Compter le nombre de tables réservées pour ce créneau
                $reservationsByDate[$date][$slotTime] += $reservation->tables->count();
                
                $currentSlot->addMinutes(30);
            }
        }
        
        // Déterminer les dates entièrement réservées et les créneaux horaires indisponibles
        foreach ($reservationsByDate as $date => $timeslots) {
            $allSlotsBooked = true;
            $dateBookedSlots = [];
            
            foreach ($timeSlots as $slot) {
                // Un créneau est considéré comme indisponible si au moins 90% des tables sont réservées
                $tablesBooked = isset($timeslots[$slot]) ? $timeslots[$slot] : 0;
                $percentageBooked = ($tablesBooked / $totalTables) * 100;
                
                if ($percentageBooked >= 90) {
                    $dateBookedSlots[] = $slot;
                } else {
                    $allSlotsBooked = false;
                }
            }
            
            // Si tous les créneaux sont réservés, considérer la journée comme complètement indisponible
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
    
    /**
     * Annule une réservation existante
     */
    public function cancelReservation($id)
    {
        $reservation = $this->reservationRepository->getById($id);
        
        // Vérifier que la réservation appartient à l'utilisateur connecté
        if ($reservation->user_id !== Auth::id()) {
            throw new \Exception('Vous n\'êtes pas autorisé à annuler cette réservation.');
        }
        
        // Vérifier que la réservation peut encore être annulée (pas déjà passée)
        if ($reservation->reservation_datetime < Carbon::now()) {
            throw new \Exception('Impossible d\'annuler une réservation passée.');
        }
        
        return $this->reservationRepository->updateReservationStatus($id, 'canceled');
    }


    public function getReservationsByRestaurant($restaurantId)
    {
        return $this->reservationRepository->getReservationsByRestaurant($restaurantId);
    }
    
    public function getReservationsByRestaurantAndDate($restaurantId, $date)
    {
        return $this->reservationRepository->getReservationsByRestaurantAndDate($restaurantId, $date);
    }
}