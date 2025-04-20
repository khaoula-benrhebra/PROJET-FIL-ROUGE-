<?php

namespace App\Services;

use App\Repositories\MenuRepository;
use App\Repositories\RestaurantRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MenuService
{
    protected $menuRepository;
    protected $restaurantRepository;
    
    public function __construct(
        MenuRepository $menuRepository,
        RestaurantRepository $restaurantRepository
    ) {
        $this->menuRepository = $menuRepository;
        $this->restaurantRepository = $restaurantRepository;
    }
    
    public function getMenusByRestaurant($restaurantId = null)
    {
        $restaurant = $restaurantId 
            ? $this->restaurantRepository->getById($restaurantId)
            : $this->restaurantRepository->getRestaurantByCurrentUser();
            
        if (!$restaurant) {
            return [];
        }
        
        return $this->menuRepository->getMenusByRestaurant($restaurant);
    }
    
    public function createMenu(array $data)
    {
        if (!Gate::allows('create_meals')) {
            throw new \Exception('Vous n\'avez pas la permission de créer des menus.');
        }
        
        $restaurant = $this->restaurantRepository->getRestaurantByCurrentUser();
        
        if (!$restaurant) {
            throw new \Exception('Vous devez d\'abord créer un restaurant.');
        }
        
        $data['restaurant_id'] = $restaurant->id;
        
        return $this->menuRepository->createMenu($data);
    }
    
    public function updateMenu($id, array $data)
    {
        if (!Gate::allows('update_meals')) {
            throw new \Exception('Vous n\'avez pas la permission de modifier des menus.');
        }
        
        $menu = $this->menuRepository->getById($id);
        
        if (!$menu) {
            throw new \Exception('Menu non trouvé.');
        }
        
        $restaurant = $this->restaurantRepository->getRestaurantByCurrentUser();
        
        if ($menu->restaurant_id !== $restaurant->id) {
            throw new \Exception('Vous ne pouvez pas modifier ce menu.');
        }
        
        return $this->menuRepository->updateMenu($id, $data);
    }
    
    public function deleteMenu($id)
    {
        if (!Gate::allows('delete_meals')) {
            throw new \Exception('Vous n\'avez pas la permission de supprimer des menus.');
        }
        
        $menu = $this->menuRepository->getById($id);
        
        if (!$menu) {
            throw new \Exception('Menu non trouvé.');
        }
        
        $restaurant = $this->restaurantRepository->getRestaurantByCurrentUser();
        
        if ($menu->restaurant_id !== $restaurant->id) {
            throw new \Exception('Vous ne pouvez pas supprimer ce menu.');
        }
        
        return $this->menuRepository->delete($id);
    }



public function initializeMenusForRestaurant($restaurantId)
{
    $menuTypes = ['petit-dejeuner', 'dejeuner', 'diner'];
    
    foreach ($menuTypes as $type) {
        $this->menuRepository->createMenu([
            'type' => $type,
            'restaurant_id' => $restaurantId
        ]);
    }
}
}