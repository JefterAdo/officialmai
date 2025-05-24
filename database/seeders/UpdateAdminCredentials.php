<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateAdminCredentials extends Seeder
{
    public function run(): void
    {
        // Mettre à jour l'email et le mot de passe de l'administrateur
        DB::table('users')
            ->where('email', 'admin@rhdp.com')
            ->update([
                'email' => 'admi@pdci-rda.ci',
                'password' => Hash::make('Admin@2024'),
                'updated_at' => now(),
            ]);
            
        $this->command->info('Les identifiants administrateur ont été mis à jour avec succès.');
    }
}
