<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Models\Restaurant;

class MenuRepository extends BaseRepository
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }
    
    public function getMenusByRestaurant(Restaurant $restaurant)
    {
        return $this->model->where('restaurant_id', $restaurant->id)
            ->with('meals')
            ->get()
            ->groupBy('type');
    }
    
    public function createMenu(array $data)
    {
        return $this->model->create($data);
    }
    
    public function updateMenu($id, array $data)
    {
        $menu = $this->getById($id);
        $menu->update($data);
        return $menu;
    }
}