<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Gate;

class CategoryService
{
    protected $categoryRepository;
    
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function getAllCategories()
    {
        return $this->categoryRepository->getAllSorted();
    }
    public function createCategory(array $data)
    {
        if (!Gate::allows('add_categories')) {
            throw new \Exception('Vous n\'avez pas la permission d\'ajouter des catégories.');
        }
        
        return $this->categoryRepository->create($data);
    }

    public function updateCategory($id, array $data)
    {
        if (!Gate::allows('update_categories')) {
            throw new \Exception('Vous n\'avez pas la permission de modifier des catégories.');
        }
        
        return $this->categoryRepository->update($id, $data);
    }
 
    public function deleteCategory($id)
    {
        if (!Gate::allows('delete_categories')) {
            throw new \Exception('Vous n\'avez pas la permission de supprimer des catégories.');
        }
        
        return $this->categoryRepository->delete($id);
    }
    public function getCategoryById($id)
    {
        return $this->categoryRepository->getById($id);
    }
}