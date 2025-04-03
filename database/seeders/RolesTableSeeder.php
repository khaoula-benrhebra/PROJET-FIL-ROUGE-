<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Administrateur'],
            ['name' => 'Gérant'],
            ['name' => 'Client']
        ];
        
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}