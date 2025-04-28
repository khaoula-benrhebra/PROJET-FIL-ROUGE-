<?php

namespace App\Repositories;

use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class ReviewRepository extends BaseRepository
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }
    
    
    public function getReviewsByRestaurant($restaurantId)
    {
        return $this->model->where('restaurant_id', $restaurantId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }
  
    public function userHasReviewedRestaurant($userId, $restaurantId)
    {
        return $this->model->where('user_id', $userId)
            ->where('restaurant_id', $restaurantId)
            ->exists();
    }
    
  
    public function createReview(array $data)
    {
        return $this->model->create([
            'user_id' => Auth::id(),
            'restaurant_id' => $data['restaurant_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment']
        ]);
    }
   
    public function getAverageRating($restaurantId)
    {
        return $this->model->where('restaurant_id', $restaurantId)
            ->avg('rating') ?? 0;
    }
}