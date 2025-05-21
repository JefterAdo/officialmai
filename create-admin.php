<?php

// Charger l'application Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

// Configuration de l'utilisateur admin avec des identifiants fictifs
$admin = [
    'name' => 'Jean Kouassi',
    'email' => 'admin@example.com',
    'password' => Hash::make('Password123!'),
];

// Vérifier si l'utilisateur existe déjà
$existingUser = User::where('email', $admin['email'])->first();

if ($existingUser) {
    echo "L'utilisateur avec l'email {$admin['email']} existe déjà.\n";
    echo "Mise à jour du mot de passe...\n";
    
    $existingUser->password = $admin['password'];
    $existingUser->save();
    
    echo "Mot de passe mis à jour avec succès pour {$admin['email']}.\n";
} else {
    // Créer un nouvel utilisateur
    $user = User::create($admin);
    
    // Vérifier si le rôle admin existe, sinon le créer
    $adminRole = Role::where('name', 'super-admin')->first();
    if (!$adminRole) {
        $adminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        echo "Rôle 'super-admin' créé.\n";
    }
    
    // Attribuer le rôle admin à l'utilisateur
    $user->assignRole('super-admin');
    
    echo "Nouvel utilisateur administrateur créé avec succès.\n";
}

echo "=================================\n";
echo "Identifiants de connexion :\n";
echo "Email : {$admin['email']}\n";
echo "Mot de passe : Password123!\n";
echo "=================================\n"; 