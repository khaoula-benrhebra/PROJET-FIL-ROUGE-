<?php

namespace App\Services;

use App\Repositories\RestaurantRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\UploadedFile;

class RestaurantService
    {
        protected $restaurantRepository;
        protected $menuService;
        
        public function __construct(RestaurantRepository $restaurantRepository ,  MenuService $menuService)
        {
            $this->restaurantRepository = $restaurantRepository;
            $this->menuService = $menuService;

        }
        public function getRestaurantByCurrentUser()
        {
            return $this->restaurantRepository->getRestaurantByCurrentUser();
        }
        public function getAllRestaurants()
        {
            return $this->restaurantRepository->getAllWithCategories();
        }
        public function createRestaurant(array $data, ?UploadedFile $image = null)
        {
            if (!Gate::allows('add_restaurant')) {
                throw new \Exception('Vous n\'avez pas la permission d\'ajouter un restaurant.');
            }
            
            $restaurant = $this->restaurantRepository->createRestaurant($data);
            
            if ($image) {
                $restaurant->addMedia($image)
                    ->toMediaCollection('restaurant');
            }
            
            $this->menuService->initializeMenusForRestaurant($restaurant->id);
            
            return $restaurant;
        }
        
        public function updateRestaurant($id, array $data, ?UploadedFile $image = null)
        {
            if (!Gate::allows('update_restaurant')) {
                throw new \Exception('Vous n\'avez pas la permission de modifier ce restaurant.');
            }
            
            $restaurant = $this->restaurantRepository->updateRestaurant($id, $data);
            
            if ($image) {
                $restaurant->clearMediaCollection('restaurant');
                $restaurant->addMedia($image)
                    ->toMediaCollection('restaurant');
            }
            
            return $restaurant;
        }
        
        public function deleteRestaurant($id)
        {
            if (!Gate::allows('delete_restaurant')) {
                throw new \Exception('Vous n\'avez pas la permission de supprimer ce restaurant.');
            }
            
            return $this->restaurantRepository->delete($id);
        }
        

        public function getRestaurantsForPublicPage()
        {
            return $this->restaurantRepository->getRestaurantsForPublicPage();
        }
        
    
        public function getRestaurantById($id)
        {
            return $this->restaurantRepository->getById($id);
        }
}