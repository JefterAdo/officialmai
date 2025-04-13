<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Créer le rôle superadmin s'il n'existe pas
        $role = Role::firstOrCreate(['name' => 'superadmin']);

        // Créer l'utilisateur admin s'il n'existe pas
        $user = User::firstOrCreate(
            ['email' => 'admin@rhdp.com'],
            [
                'name' => 'Super Admin',
                'email' => 'admin@rhdp.com',
                'password' => Hash::make('password'),
            ]
        );

        // Assigner le rôle
        $user->assignRole($role);
    }
} 