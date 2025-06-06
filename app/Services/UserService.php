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
        $roleName = $data['role'] === 'restaurant_manager' ? 'Gérant' : 'Client';
        $role = $this->roleRepository->findByName($roleName);
        
        if (!$role) {
            throw new \Exception("Rôle '$roleName' non trouvé dans la base de données.");
        }
        
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $role->id,
            'is_approved' => $roleName === 'Client' 
        ];
        
        
        return $this->userRepository->create($userData);
    }
    
    public function getPendingManagers()
    {
        return $this->userRepository->getPendingManagers();
    }

    public function getAllManagers()
{
    return $this->userRepository->getAllManagers();
}
    
    public function approveManager($id)
    {
        return $this->userRepository->approveManager($id);
    }
    
public function deleteUser($id)
{
    $user = $this->userRepository->getById($id);
    
    if ($user->role->name === 'Gérant') {
        $restaurant = $user->restaurant;
        if ($restaurant) {
            $restaurant->delete();
        }
    }
    
    return $this->userRepository->delete($id);
}
}