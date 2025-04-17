<?php

namespace App\Http\Controllers;

use App\Services\RestaurantService;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurantService;
    protected $categoryRepository;
    
    public function __construct(RestaurantService $restaurantService, CategoryRepository $categoryRepository)
    {
        $this->restaurantService = $restaurantService;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $restaurants = $this->restaurantService->getRestaurantsForPublicPage();
        $categories = $this->categoryRepository->getAllSorted();
        
    
        $categoryId = $request->input('category');
        if ($categoryId) {
            $restaurants = $restaurants->filter(function($restaurant) use ($categoryId) {
                return $restaurant->categories->contains('id', $categoryId);
            });
        }
        
       
        $search = $request->input('search');
        if ($search) {
            $restaurants = $restaurants->filter(function($restaurant) use ($search) {
                return stripos($restaurant->name, $search) !== false || 
                       stripos($restaurant->address, $search) !== false ||
                       stripos($restaurant->description, $search) !== false;
            });
        }
        
        return view('pages.restaurants', compact('restaurants', 'categories'));
    }
  
    public function show($id)
    {
        $restaurant = $this->restaurantService->getRestaurantById($id);
        return view('pages.restaurant_detail', compact('restaurant'));
    }
}