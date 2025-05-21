<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Créer un utilisateur administrateur';

    public function handle()
    {
        $email = 'admin@pdci-rda.ci';
        $password = 'Admin@2024';
        
        // Vérifier si l'utilisateur existe déjà
        if (User::where('email', $email)->exists()) {
            $this->error('Un utilisateur avec cet email existe déjà !');
            return;
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => 'Administrateur',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Utilisateur administrateur créé avec succès !');
        $this->info('Email: ' . $email);
        $this->info('Mot de passe: ' . $password);
    }
} 