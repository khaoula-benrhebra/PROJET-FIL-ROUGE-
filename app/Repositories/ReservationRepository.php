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
    
    /**
     * Récupère les réservations d'un restaurant spécifique
     */
    public function getReservationsByRestaurant($restaurantId)
    {
        return $this->model->where('restaurant_id', $restaurantId)
            ->with(['user', 'tables', 'meals'])
            ->orderBy('reservation_datetime', 'desc')
            ->get();
    }
    
    /**
     * Récupère les réservations d'un restaurant pour une date spécifique
     */
    public function getReservationsByRestaurantAndDate($restaurantId, Carbon $date)
    {
        return $this->model->where('restaurant_id', $restaurantId)
            ->whereDate('reservation_datetime', $date->toDateString())
            ->with(['user', 'tables', 'meals'])
            ->get();
    }
    
    /**
     * Récupère les réservations de l'utilisateur connecté
     */
    public function getReservationsByCurrentUser()
    {
        return $this->model->where('user_id', Auth::id())
            ->with(['restaurant', 'tables', 'meals'])
            ->orderBy('reservation_datetime', 'desc')
            ->get();
    }
    
    /**
     * Vérifie la disponibilité des tables à une date et heure spécifiques
     */
    public function getAvailableTables($restaurantId, $reservationDatetime, $guests)
    {
        // Récupérer toutes les tables du restaurant
        $tables = Table::where('restaurant_id', $restaurantId)->get();
        
        // Récupérer les IDs des tables déjà réservées à cette date et heure
        $startTime = Carbon::parse($reservationDatetime)->subHours(2); // 2 heures avant
        $endTime = Carbon::parse($reservationDatetime)->addHours(2);   // 2 heures après
        
        $reservedTableIds = DB::table('reservation_table')
            ->join('reservations', 'reservation_table.reservation_id', '=', 'reservations.id')
            ->where('reservations.restaurant_id', $restaurantId)
            ->where('reservations.status', '!=', 'canceled')
            ->whereBetween('reservations.reservation_datetime', [$startTime, $endTime])
            ->pluck('reservation_table.table_id')
            ->toArray();
        
        // Filtrer les tables disponibles
        $availableTables = $tables->reject(function($table) use ($reservedTableIds) {
            return in_array($table->id, $reservedTableIds);
        });
        
        return $availableTables;
    }
    
    /**
     * Crée une nouvelle réservation
     */
    public function createReservation(array $data)
    {
        DB::beginTransaction();
        
        try {
            // Créer la réservation de base
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
                'status' => 'pending'
            ]);
            
            // Attacher les tables si présentes
            if (isset($data['tables']) && is_array($data['tables'])) {
                $reservation->tables()->attach($data['tables']);
            }
            
            // Attacher les repas si présents
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
    
    /**
     * Met à jour le statut d'une réservation
     */
    public function updateReservationStatus($id, $status)
    {
        $reservation = $this->getById($id);
        $reservation->update(['status' => $status]);
        return $reservation;
    }
}