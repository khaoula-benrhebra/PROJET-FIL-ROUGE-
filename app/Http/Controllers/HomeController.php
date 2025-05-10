<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\RestaurantService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $categoryService;
    protected $restaurantService;
    
    public function __construct(CategoryService $categoryService, RestaurantService $restaurantService)
    {
        $this->categoryService = $categoryService;
        $this->restaurantService = $restaurantService;
    }
    
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        $topRestaurants = $this->restaurantService->getTopRestaurantsByReservations(6);
        
        return view('pages.home', compact('categories', 'topRestaurants'));
    }
}