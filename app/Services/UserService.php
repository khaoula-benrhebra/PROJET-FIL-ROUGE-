<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;
    protected $roleRepository;
    
    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }
    
    public function createUser(array $data)
    {
        // Déterminer le rôle
        $roleName = $data['role'] === 'restaurant_manager' ? 'Gérant' : 'Client';
        $role = $this->roleRepository->findByName($roleName);
        
        // Créer l'utilisateur
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $role->id,
            'is_approved' => $roleName === 'Client' // Approuver automatiquement les clients
        ];
      
        
        return $this->userRepository->create($userData);
    }
    
    public function getPendingManagers()
    {
        return $this->userRepository->getPendingManagers();
    }
    
    public function approveManager($id)
    {
        return $this->userRepository->approveManager($id);
    }
}