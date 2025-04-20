<?php

namespace App\Repositories;

use App\Models\Table;

class TableRepository extends BaseRepository
{
    public function __construct(Table $model)
    {
        parent::__construct($model);
    }
    
    public function getTablesByRestaurantId($restaurantId)
    {
        return $this->model->where('restaurant_id', $restaurantId)
            ->orderBy('table_label')
            ->get();
    }
    
    public function createTables($restaurantId, array $tableLabels, $isAvailable = true)
    {
        $tables = [];
        
        foreach ($tableLabels as $label) {
            $tables[] = $this->model->create([
                'restaurant_id' => $restaurantId,
                'table_label' => $label,
                'is_available' => $isAvailable
            ]);
        }
        
        return $tables;
    }
}