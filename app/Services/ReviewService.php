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
 
    public function canReviewRestaurant($restaurantId)
    {
        if (!Gate::allows('add_review')) {
            return false;
        }
        
        $reservations = $this->reservationRepository->getReservationsByCurrentUser();
        
        return $reservations->where('restaurant_id', $restaurantId)->count() > 0;
    }
    
   
    public function createReview(array $data)
    {
        if (!$this->canReviewRestaurant($data['restaurant_id'])) {
            throw new \Exception('Vous devez avoir réservé dans ce restaurant pour pouvoir laisser un avis.');
        }
        
        return $this->reviewRepository->createReview($data);
    }
   
    public function getReviewsByRestaurant($restaurantId)
    {
        return $this->reviewRepository->getReviewsByRestaurant($restaurantId);
    }
    
    
    public function getAverageRating($restaurantId)
    {
        return $this->reviewRepository->getAverageRating($restaurantId);
    }
}