<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantService;
use App\Services\StatisticsService;
use App\Services\UserService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurantService;
    protected $statisticsService;
    protected $userService;
    protected $categoryService;
    
    public function __construct(RestaurantService $restaurantService, StatisticsService $statisticsService, UserService $userService, CategoryService $categoryService)
    {
        $this->middleware('auth');
        $this->middleware('role:Administrateur');
        $this->restaurantService = $restaurantService;
        $this->statisticsService = $statisticsService;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }
    
   
    public function index()
    {
        $restaurants = $this->restaurantService->getAllRestaurants();
        $statistics = $this->statisticsService->getDashboardStatistics();
        $allManagers = $this->userService->getAllManagers();
        $categories = $this->categoryService->getAllCategories();
        return view('pages.admin.dashboard', compact('restaurants', 'statistics', 'allManagers', 'categories'));
    }
    
  
    public function destroy($id)
    {
        try {
            $this->restaurantService->deleteRestaurant($id);
            return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.restaurants.index')->with('error', $e->getMessage());
        }
    }
}