<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer le super administrateur
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@rhdp.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Assigner le rôle super-admin
        $admin->assignRole('super-admin');
    }
}
