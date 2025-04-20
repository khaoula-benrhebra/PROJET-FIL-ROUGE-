<?php

namespace App\Services;

use App\Repositories\MealRepository;
use App\Repositories\MenuRepository;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;

class MealService
{
    protected $mealRepository;
    protected $menuRepository;
    protected $restaurantRepository;
    
    public function __construct(
        MealRepository $mealRepository,
        MenuRepository $menuRepository,
        RestaurantRepository $restaurantRepository
    ) {
        $this->mealRepository = $mealRepository;
        $this->menuRepository = $menuRepository;
        $this->restaurantRepository = $restaurantRepository;
    }
    
    public function getMealsByMenu($menuId)
    {
        $menu = $this->menuRepository->getById($menuId);
        
        if (!$menu) {
            throw new \Exception('Menu non trouvé.');
        }
        
        return $this->mealRepository->getMealsByMenu($menu);
    }
    
    public function createMeal(array $data, ?UploadedFile $image = null)
    {
        if (!Gate::allows('create_meals')) {
            throw new \Exception('Vous n\'avez pas la permission de créer des repas.');
        }
        
        $menu = $this->menuRepository->getById($data['menu_id']);
        
        if (!$menu) {
            throw new \Exception('Menu non trouvé.');
        }
        
        $restaurant = $this->restaurantRepository->getRestaurantByCurrentUser();
        
        if ($menu->restaurant_id !== $restaurant->id) {
            throw new \Exception('Vous ne pouvez pas créer des repas pour ce menu.');
        }
        
        $meal = $this->mealRepository->createMeal($data);
        
        if ($image) {
            $meal->addMedia($image)
                ->toMediaCollection('meal');
        }
        
        return $meal;
    }
    
    public function updateMeal($id, array $data, ?UploadedFile $image = null)
    {
        if (!Gate::allows('update_meals')) {
            throw new \Exception('Vous n\'avez pas la permission de modifier des repas.');
        }
        
        $meal = $this->mealRepository->getById($id);
        
        if (!$meal) {
            throw new \Exception('Repas non trouvé.');
        }
        
        $restaurant = $this->restaurantRepository->getRestaurantByCurrentUser();
        
        if ($meal->menu->restaurant_id !== $restaurant->id) {
            throw new \Exception('Vous ne pouvez pas modifier ce repas.');
        }
        
        $updatedMeal = $this->mealRepository->updateMeal($id, $data);
        
        if ($image) {
            $meal->clearMediaCollection('meal');
            $meal->addMedia($image)
                ->toMediaCollection('meal');
        }
        
        return $updatedMeal;
    }
    
    public function deleteMeal($id)
    {
        if (!Gate::allows('delete_meals')) {
            throw new \Exception('Vous n\'avez pas la permission de supprimer des repas.');
        }
        
        $meal = $this->mealRepository->getById($id);
        
        if (!$meal) {
            throw new \Exception('Repas non trouvé.');
        }
        
        $restaurant = $this->restaurantRepository->getRestaurantByCurrentUser();
        
        if ($meal->menu->restaurant_id !== $restaurant->id) {
            throw new \Exception('Vous ne pouvez pas supprimer ce repas.');
        }
        
        return $this->mealRepository->delete($id);
    }


    public function getMeal($id)
{
    if (!Gate::allows('create_meals') && !Gate::allows('update_meals')) {
        throw new \Exception('Vous n\'avez pas la permission de consulter ce repas.');
    }
    
    $meal = $this->mealRepository->getById($id);
    
    if (!$meal) {
        throw new \Exception('Repas non trouvé.');
    }
    
    $restaurant = $this->restaurantRepository->getRestaurantByCurrentUser();
    
    if ($meal->menu->restaurant_id !== $restaurant->id) {
        throw new \Exception('Vous ne pouvez pas consulter ce repas.');
    }
    
    return $meal;
}
}