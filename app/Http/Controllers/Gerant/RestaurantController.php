<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Repositories\CategoryRepository;
use App\Services\RestaurantService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $categoryRepository;
    protected $restaurantService;
    
    public function __construct(CategoryRepository $categoryRepository, RestaurantService $restaurantService)
    {
        $this->middleware('auth');
        $this->middleware('role:Gérant');
        $this->categoryRepository = $categoryRepository;
        $this->restaurantService = $restaurantService;
    }
 
    public function index()
    {
        $categories = $this->categoryRepository->getAllSorted();
        $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
        
        return view('pages.gerant.restaurant', compact('categories', 'restaurant'));
    }
    
 
    public function create()
    {
        $categories = $this->categoryRepository->getAllSorted();
        return view('pages.gerant.restaurant_create', compact('categories'));
    }
    

    public function store(CreateRestaurantRequest $request)
    {
        try {
            $this->restaurantService->createRestaurant(
                $request->validated(), 
                $request->hasFile('image') ? $request->file('image') : null
            );
            
            return redirect()->route('gerant.restaurant.index')->with('success', 'Restaurant créé avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    
    public function edit()
    {
        $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
        
        if (!$restaurant) {
            return redirect()->route('gerant.restaurant.create')
                ->with('info', 'Veuillez d\'abord créer votre restaurant.');
        }
        
        $categories = $this->categoryRepository->getAllSorted();
        $selectedCategories = $restaurant->categories->pluck('id')->toArray();
        
        return view('pages.gerant.restaurant_edit', compact('restaurant', 'categories', 'selectedCategories'));
    }
    
    public function update(UpdateRestaurantRequest $request)
    {
        try {
            $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
            
            if (!$restaurant) {
                return redirect()->route('gerant.restaurant.create')
                    ->with('info', 'Veuillez d\'abord créer votre restaurant.');
            }
            
            $this->restaurantService->updateRestaurant(
                $restaurant->id,
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );
            
            return redirect()->route('gerant.restaurant.index')->with('success', 'Restaurant mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }


public function toggleCategory(Request $request)
{

    $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
    
    if (!$restaurant) {
        return response()->json([
            'success' => false,
            'message' => 'Vous devez d\'abord créer un restaurant'
        ]);
    }

    $categoryId = $request->category_id;
    $isChecked = $request->checked;
    
    if ($isChecked) {
        $restaurant->categories()->syncWithoutDetaching([$categoryId]);
        $message = 'Catégorie ajoutée à votre restaurant';
    } else {
        $restaurant->categories()->detach($categoryId);
        $message = 'Catégorie retirée de votre restaurant';
    }
    
    return response()->json([
        'success' => true,
        'message' => $message
    ]);
}
}