<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Réinitialiser les caches des rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            // Permissions pour les pages
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',
            
            // Permissions pour les médias
            'view media',
            'upload media',
            'delete media',
            
            // Permissions pour les actualités
            'view news',
            'create news',
            'edit news',
            'delete news',
            
            // Permissions pour les utilisateurs
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Permissions pour les rôles
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Permissions pour les paramètres
            'view settings',
            'edit settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer les rôles et assigner les permissions
        $roles = [
            'super-admin' => $permissions,
            'admin' => [
                'view pages', 'create pages', 'edit pages', 'delete pages',
                'view media', 'upload media', 'delete media',
                'view news', 'create news', 'edit news', 'delete news',
                'view users', 'create users', 'edit users',
                'view roles',
                'view settings', 'edit settings',
            ],
            'editor' => [
                'view pages', 'create pages', 'edit pages',
                'view media', 'upload media',
                'view news', 'create news', 'edit news',
            ],
            'author' => [
                'view pages',
                'view media', 'upload media',
                'view news', 'create news',
            ],
        ];

        foreach ($roles as $role => $rolePermissions) {
            $createdRole = Role::create(['name' => $role]);
            $createdRole->givePermissionTo($rolePermissions);
        }
    }
}
