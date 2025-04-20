<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Services\MealService;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MenuController extends Controller
{
    protected $menuService;
    protected $mealService;
    
    public function __construct(MenuService $menuService, MealService $mealService)
    {
        $this->middleware('auth');
        $this->middleware('role:Gérant');
        $this->menuService = $menuService;
        $this->mealService = $mealService;
    }
    
    public function index()
    {
        $menusByType = $this->menuService->getMenusByRestaurant();
        
        return view('pages.gerant.menu', compact('menusByType'));
    }
    
    // Nouvelle méthode pour afficher le formulaire de création de repas
    public function createMeal(Request $request)
    {
        $menu_id = $request->input('menu_id');
        $type = $request->input('type');
        
        if (!$menu_id) {
            return redirect()->route('gerant.menu')->with('error', 'Menu non spécifié');
        }
        
        return view('pages.gerant.meal-create', compact('menu_id', 'type'));
    }
    
    // Nouvelle méthode pour afficher le formulaire d'édition de repas
    public function editMeal($id)
    {
        try {
            $meal = $this->mealService->getMeal($id);
            return view('pages.gerant.meal-edit', compact('meal'));
        } catch (\Exception $e) {
            return redirect()->route('gerant.menu')->with('error', $e->getMessage());
        }
    }
    
    public function storeMeal(CreateMealRequest $request)
    {
        try {
            $this->mealService->createMeal(
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );
            
            return redirect()->route('gerant.menu')->with('success', 'Repas ajouté avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    
    public function updateMeal(UpdateMealRequest $request, $id)
    {
        try {
            $this->mealService->updateMeal(
                $id,
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );
            
            return redirect()->route('gerant.menu')->with('success', 'Repas mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
    
    public function deleteMeal($id)
    {
        try {
            $this->mealService->deleteMeal($id);
            
            return redirect()->route('gerant.menu')->with('success', 'Repas supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()->route('gerant.menu')->with('error', $e->getMessage());
        }
    }
    
    public function getMeal($id)
    {
        try {
            $meal = $this->mealService->getMeal($id);
            
            // Assurez-vous de retourner toutes les données nécessaires
            return response()->json([
                'success' => true,
                'meal' => $meal,

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}