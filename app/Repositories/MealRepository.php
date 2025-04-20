<?php

namespace App\Repositories;

use App\Models\Meal;
use App\Models\Menu;

class MealRepository extends BaseRepository
{
    public function __construct(Meal $model)
    {
        parent::__construct($model);
    }
    
    public function getMealsByMenu(Menu $menu)
    {
        return $this->model->where('menu_id', $menu->id)->get();
    }
    
    public function createMeal(array $data)
    {
        return $this->model->create($data);
    }
    
    public function updateMeal($id, array $data)
    {
        $meal = $this->getById($id);
        $meal->update($data);
        return $meal;
    }
}