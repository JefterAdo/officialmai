<?php

namespace Tests\Feature\Helpers;

use App\Models\User;
use Spatie\Permission\Models\Role;

class TestHelper
{
    public static function createAdminUser()
    {
        // Créer le rôle admin s'il n'existe pas
        $role = Role::firstOrCreate(['name' => 'admin']);
        
        // Créer un utilisateur admin
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        $admin->assignRole($role);
        
        return $admin;
    }
}
