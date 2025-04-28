<?php

namespace App\Services;

use App\Repositories\ReviewRepository;
use App\Repositories\ReservationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewService
{
    protected $reviewRepository;
    protected $reservationRepository;
    
    public function __construct(
        ReviewRepository $reviewRepository,
        ReservationRepository $reservationRepository
    ) {
        $this->reviewRepository = $reviewRepository;
        $this->reservationRepository = $reservationRepository;
    }
    
    
    public function getReviewsByRestaurant($restaurantId)
    {
        return $this->reviewRepository->getReviewsByRestaurant($restaurantId);
    }
    
   
    public function userCanReviewRestaurant($restaurantId)
    {
        if (!Auth::check()) {
            return false;
        }
        
        if ($this->reviewRepository->hasUserReviewedRestaurant(Auth::id(), $restaurantId)) {
            return false;
        }
        
        $userReservations = $this->reservationRepository->getReservationsByCurrentUser();
        $hasConfirmedReservation = $userReservations->where('restaurant_id', $restaurantId)
            ->where('status', 'confirmed')
            ->count() > 0;
            
        return $hasConfirmedReservation;
    }
    
    public function createReview(array $data)
    {
        if (!Gate::allows('add_review', $data['restaurant_id'])) {
            throw new \Exception('Vous n\'avez pas la permission d\'ajouter un avis pour ce restaurant.');
        }
        
        return $this->reviewRepository->createReview($data);
    }
    
   
    public function getAverageRatingForRestaurant($restaurantId)
    {
        return $this->reviewRepository->getAverageRatingForRestaurant($restaurantId);
    }
    
    
    public function hasUserReviewedRestaurant($restaurantId)
    {
        if (!Auth::check()) {
            return false;
        }
        
        return $this->reviewRepository->hasUserReviewedRestaurant(Auth::id(), $restaurantId);
    }
}