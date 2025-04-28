<?php

namespace App\Http\Controllers;

use App\Services\RestaurantService;
use App\Services\MenuService;
use App\Services\ReviewService;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurantService;
    protected $categoryRepository;
    protected $menuService;
    protected $reviewService;
    
    public function __construct(
        RestaurantService $restaurantService, 
        CategoryRepository $categoryRepository,
        MenuService $menuService,
        ReviewService $reviewService
    ) {
        $this->restaurantService = $restaurantService;
        $this->categoryRepository = $categoryRepository;
        $this->menuService = $menuService;
        $this->reviewService = $reviewService;
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
        
        if (!$restaurant) {
            return redirect()->route('restaurants')->with('error', 'Restaurant introuvable.');
        }
        
        $menus = [];
        
        $menusByType = $this->menuService->getMenusByRestaurant($restaurant->id);
        foreach ($menusByType as $type => $typeMenus) {
            if (!empty($typeMenus) && count($typeMenus) > 0) {
                $menus[$type] = $typeMenus[0]; 
            }
        }
        
        $reviews = $this->reviewService->getReviewsByRestaurant($restaurant->id);
        
        $averageRating = $this->reviewService->getAverageRating($restaurant->id);
        
        return view('pages.restaurant_detail', compact('restaurant', 'menus', 'reviews', 'averageRating'));
    }
}