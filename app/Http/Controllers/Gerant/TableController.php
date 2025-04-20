<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTablesRequest;
use App\Services\TableService;
use App\Services\RestaurantService;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected $tableService;
    protected $restaurantService;
    
    public function __construct(TableService $tableService, RestaurantService $restaurantService)
    {
        $this->middleware('auth');
        $this->middleware('role:Gérant');
        $this->tableService = $tableService;
        $this->restaurantService = $restaurantService;
    }
    
    public function index()
    {
        $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
        
        if (!$restaurant) {
            return redirect()->route('gerant.restaurant.index')
                ->with('info', 'Veuillez d\'abord créer votre restaurant.');
        }
        
        $tables = [];
        
        if ($restaurant->id) {
            $tables = $this->tableService->getTablesByRestaurantId($restaurant->id);
        }
        
        return view('pages.gerant.tables', compact('restaurant', 'tables'));
    }
    
    public function store(CreateTablesRequest $request)
    {
        try {
            $restaurant = $this->restaurantService->getRestaurantByCurrentUser();
            
            if (!$restaurant) {
                return redirect()->route('gerant.restaurant.index')
                    ->with('info', 'Veuillez d\'abord créer votre restaurant.');
            }
            
           
            $existingTablesCount = $this->tableService->getTablesByRestaurantId($restaurant->id)->count();
            
           
            $newTablesCount = count($request->table_labels);
            $totalTablesCount = $existingTablesCount + $newTablesCount;
            
            if ($totalTablesCount > $restaurant->number_of_tables) {
                return redirect()->back()
                    ->with('error', 'Vous ne pouvez pas créer plus de ' . $restaurant->number_of_tables . ' tables. Vous avez déjà ' . $existingTablesCount . ' tables.')
                    ->withInput();
            }
            
            
            $this->tableService->createTables($restaurant->id, $request->table_labels);
            
            return redirect()->route('gerant.tables.index')
                ->with('success', count($request->table_labels) . ' tables ont été créées avec succès.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
    
   
    public function initializeTablesFromRestaurant(Request $request, $restaurantId, $numberOfTables)
    {
        try {
            $restaurant = $this->restaurantService->getRestaurantById($restaurantId);
            
            if (!$restaurant) {
                throw new \Exception('Restaurant non trouvé.');
            }
            
            $tableLabels = $this->tableService->generateTableLabels($numberOfTables);
            
           
            $this->tableService->createTables($restaurant->id, $tableLabels);
            
            return redirect()->route('gerant.tables.index')
                ->with('success', $numberOfTables . ' tables ont été créées avec succès.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}