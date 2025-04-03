<?php
namespace App\Services;

use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;

class RoleService
{
    protected $roleRepository;
    protected $permissionRepository;
    
    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }
    
    public function getAllRoles()
    {
        return $this->roleRepository->getAll();
    }
    
    public function syncRolePermissions($roleId, array $permissionIds)
    {
        $role = $this->roleRepository->getById($roleId);
        return $role->permissions()->sync($permissionIds);
    }
}