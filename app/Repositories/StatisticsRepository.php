<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Category;
use App\Models\Restaurant;

class StatisticsRepository
{
    public function getUsersCount()
    {
        return User::count();
    }

    public function getCategoriesCount()
    {
        return Category::count();
    }

    public function getRestaurantsCount()
    {
        return Restaurant::count();
    }
} 