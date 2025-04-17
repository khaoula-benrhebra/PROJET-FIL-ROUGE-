<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\RestaurantService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurantService;
    
    public function __construct(RestaurantService $restaurantService)
    {
        $this->middleware('auth');
        $this->middleware('role:Administrateur');
        $this->restaurantService = $restaurantService;
    }
    
   
    public function index()
    {
        $restaurants = $this->restaurantService->getAllRestaurants();
        return view('pages.admin.restaurants.index', compact('restaurants'));
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