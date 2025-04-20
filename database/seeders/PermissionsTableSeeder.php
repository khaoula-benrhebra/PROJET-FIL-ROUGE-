<?php
namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissionIds = [];
        $permissions = [
            'manage_restaurant_managers' => 'Gérer les Gérants de Restaurant',
            'approve_restaurant_managers' => 'Approuver les Gérants de Restaurant',
            'view_dashboard' => 'Voir le tableau de bord',
            'add_categories' => 'Ajouter les catégories',
            'update_categories' => 'Modifier les catégories',
            'delete_categories' => 'Supprimer les catégories',
            'add_restaurant'=>'Ajouter un restaurant',
            'update_restaurant'=>'Modifier un restaurant',
            'delete_restaurant'=>'Supprimer un restaurant',
            'create_meals'=>'ajouter un repas',
            'update_meals'=>'Modifier un repas',
            'delete_meals'=>'Supprimer un repas',
            'add_table'=>'Ajouter une table',
            'view_statistics' => 'Voir les statistiques',
            'create_reservation' => 'Créer une réservation',
           'manage_profile' => 'Gérer son profil et ses médias',
            'manage_reservations' => 'Gérer les réservations',
            'add_review' => 'Ajouter un avis',
            'respond_to_review' => 'Répondre aux avis',
            'manage_favorites' => 'Gérer les favoris'
        ];
        
        foreach ($permissions as $id => $name) {
            Permission::create(['id' => $id, 'name' => $name]);
            $permissionIds[$id] = $id;
        }
        
      
        $adminRole = Role::where('name', 'Administrateur')->first();
        $gerantRole = Role::where('name', 'Gérant')->first();
        $clientRole = Role::where('name', 'Client')->first();
        
    
        $adminPermissions = [
            $permissionIds['manage_restaurant_managers'],
            $permissionIds['approve_restaurant_managers'],
            $permissionIds['view_dashboard'],
            $permissionIds['add_categories'],
            $permissionIds['update_categories'],
            $permissionIds['delete_categories'],
            $permissionIds['manage_profile'],
            $permissionIds['delete_restaurant'],
            $permissionIds['view_statistics'],
            $permissionIds['manage_reservations']
        ];
        $adminRole->permissions()->attach($adminPermissions);
        
        
        $gerantPermissions = [
            $permissionIds['view_dashboard'],
            $permissionIds['manage_reservations'],
            $permissionIds['respond_to_review'],
            $permissionIds['view_statistics'],
            $permissionIds['manage_profile'],
            $permissionIds['add_restaurant'],
            $permissionIds['update_restaurant'],
            $permissionIds['create_meals'],
            $permissionIds['update_meals'],
            $permissionIds['delete_meals'],
            $permissionIds['add_table']
        ];
        $gerantRole->permissions()->attach($gerantPermissions);
        
       
        $clientPermissions = [
            $permissionIds['create_reservation'],
            $permissionIds['add_review'],
            $permissionIds['manage_favorites'],
            $permissionIds['manage_profile']
        ];
        $clientRole->permissions()->attach($clientPermissions);
    }
}