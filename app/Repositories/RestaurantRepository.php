<?php

namespace App\Repositories;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;

class RestaurantRepository extends BaseRepository
{
    public function __construct(Restaurant $model)
    {
        parent::__construct($model);
    }

    public function getRestaurantByCurrentUser()
    {
        return $this->model->where('user_id', Auth::id())
            ->with('categories')
            ->first();
    }

    public function getAllWithCategories()
    {
        return $this->model->with(['categories', 'user'])->get();
    }
    

    public function createRestaurant(array $data)
    {
        $restaurant = $this->model->create([
            'name' => $data['name'],
            'address' => $data['address'],
            'description' => $data['description'] ?? null,
            'number_of_tables' => $data['number_of_tables'] ?? null,
            'seats_per_table' => $data['seats_per_table'] ?? null,
            'user_id' => Auth::id()
        ]);
        
        if (isset($data['categories'])) {
            $restaurant->categories()->attach($data['categories']);
        }
        
        return $restaurant;
    }
 
    public function updateRestaurant($id, array $data)
    {
        $restaurant = $this->getById($id);
        
        $restaurant->update([
            'name' => $data['name'],
            'address' => $data['address'],
            'description' => $data['description'] ?? null,
            'number_of_tables' => $data['number_of_tables'] ?? null,
            'seats_per_table' => $data['seats_per_table'] ?? null,
        ]);
        
        if (isset($data['categories'])) {
            $restaurant->categories()->sync($data['categories']);
        }
        
        return $restaurant;
    }
    
    public function getRestaurantsForPublicPage()
    {
        return $this->model->with(['categories', 'user'])
            ->whereHas('user', function($query) {
                $query->where('is_approved', true);
            })
            ->get();
    }
}