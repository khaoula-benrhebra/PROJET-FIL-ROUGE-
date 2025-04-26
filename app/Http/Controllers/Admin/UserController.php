<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\CategoryService;
use App\Services\RestaurantService;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $categoryService;
    protected $restaurantService;
    protected $statisticsService;
    
    public function __construct(
        UserService $userService, 
        CategoryService $categoryService,
        RestaurantService $restaurantService,
        StatisticsService $statisticsService
    ) {
        $this->middleware('role:Administrateur');
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->restaurantService = $restaurantService;
        $this->statisticsService = $statisticsService;
    }
    
    public function index()
    {
        $pendingManagers = $this->userService->getPendingManagers();
        $allManagers = $this->userService->getAllManagers();
        $categories = $this->categoryService->getAllCategories();
        $restaurants = $this->restaurantService->getAllRestaurants();
        $statistics = $this->statisticsService->getDashboardStatistics();
        
        return view('pages.admin.dashboard', compact(
            'pendingManagers', 
            'allManagers', 
            'categories',
            'restaurants',
            'statistics'
        ));
    }
    
    public function approve($id)
    {
        $this->userService->approveManager($id);
        return redirect()->back()->with('success', 'Gérant approuvé avec succès.');
    }
    
    public function delete($id)
    {
        try {
            $this->userService->deleteUser($id);
            return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'utilisateur.');
        }
    }
}