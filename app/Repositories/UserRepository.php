<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    
    public function getPendingManagers()
    {
        return $this->model
            ->whereHas('role', function($query) {
                $query->where('name', 'Gérant');
            })
            ->where('is_approved', false)
            ->get();
    }


    public function getAllManagers()
{
    return $this->model
        ->whereHas('role', function($query) {
            $query->where('name', 'Gérant'); 
    })->get();
}
    
    public function approveManager($id)
    {
        return $this->update($id, ['is_approved' => true]);
    }
}
