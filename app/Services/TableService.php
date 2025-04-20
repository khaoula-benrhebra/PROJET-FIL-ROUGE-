<?php

namespace App\Services;

use App\Repositories\TableRepository;
use App\Repositories\RestaurantRepository;
use Illuminate\Support\Facades\Gate;

class TableService
{
    protected $tableRepository;
    protected $restaurantRepository;
    
    public function __construct(TableRepository $tableRepository, RestaurantRepository $restaurantRepository)
    {
        $this->tableRepository = $tableRepository;
        $this->restaurantRepository = $restaurantRepository;
    }
    
    public function getTablesByRestaurantId($restaurantId)
    {
        return $this->tableRepository->getTablesByRestaurantId($restaurantId);
    }
    
    public function createTables($restaurantId, array $tableLabels)
    {
        if (!Gate::allows('add_table')) {
            throw new \Exception('Vous n\'avez pas la permission d\'ajouter des tables.');
        }
        
        return $this->tableRepository->createTables($restaurantId, $tableLabels);
    }
    
    public function generateTableLabels($numberOfTables)
    {
        $tableLabels = [];
        for ($i = 1; $i <= $numberOfTables; $i++) {
            $tableLabels[] = 'Table ' . $i;
        }
        
        return $tableLabels;
    }
}