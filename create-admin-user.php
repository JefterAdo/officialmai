<?php

// Charger l'environnement Laravel
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

// Données de l'utilisateur
$userData = [
    'name' => 'Jean Kouassi',
    'email' => 'admin@example.com',
    'password' => Hash::make('Password123!'),
    'email_verified_at' => now()
];

// Créer ou mettre à jour l'utilisateur
$user = User::updateOrCreate(
    ['email' => $userData['email']],
    $userData
);

echo "Utilisateur créé/mis à jour avec succès.\n";

// Créer le rôle admin s'il n'existe pas
$adminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

// Attribuer le rôle à l'utilisateur s'il ne l'a pas déjà
if (!$user->hasRole('super-admin')) {
    $user->assignRole('super-admin');
    echo "Rôle 'super-admin' attribué à l'utilisateur.\n";
} else {
    echo "L'utilisateur a déjà le rôle 'super-admin'.\n";
}

echo "\n=================================\n";
echo "Identifiants de connexion :\n";
echo "Email : {$userData['email']}\n";
echo "Mot de passe : Password123!\n";
echo "=================================\n"; 