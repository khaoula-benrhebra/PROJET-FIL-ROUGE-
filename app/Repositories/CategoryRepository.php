<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
    
    public function getAllSorted()
    {
        return $this->model->orderBy('name', 'asc')->get();
    }
    
    public function nameExists($name, $exceptId = null)
    {
        $query = $this->model->where('name', $name);
        
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }
        
        return $query->exists();
    }
}