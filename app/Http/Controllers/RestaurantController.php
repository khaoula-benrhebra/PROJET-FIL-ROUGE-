<?php

namespace App\Http\Controllers;

use App\Services\RestaurantService;
use App\Services\MenuService;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurantService;
    protected $categoryRepository;
    protected $menuService;
    
    public function __construct(
        RestaurantService $restaurantService, 
        CategoryRepository $categoryRepository,
        MenuService $menuService
    ) {
        $this->restaurantService = $restaurantService;
        $this->categoryRepository = $categoryRepository;
        $this->menuService = $menuService;
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
        
        // Récupérer les menus du restaurant
        $menus = [];
        
        // Vérifier si le restaurant existe
        if ($restaurant) {
            $menusByType = $this->menuService->getMenusByRestaurant($restaurant->id);
            
            // Organiser les menus par type
            foreach ($menusByType as $type => $typeMenus) {
                if (!empty($typeMenus) && count($typeMenus) > 0) {
                    $menus[$type] = $typeMenus[0]; // On prend le premier menu de chaque type
                }
            }
        }
        
        return view('pages.restaurant_detail', compact('restaurant', 'menus'));
    }
} 