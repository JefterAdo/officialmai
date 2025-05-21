<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignAdminRole extends Command
{
    protected $signature = 'admin:role';
    protected $description = 'Assigner le rôle super-admin à l\'utilisateur administrateur';

    public function handle()
    {
        // Créer le rôle s'il n'existe pas
        if (!Role::where('name', 'super-admin')->exists()) {
            Role::create(['name' => 'super-admin']);
            $this->info('Rôle super-admin créé.');
        }

        // Trouver l'utilisateur
        $user = User::where('email', 'admin@pdci-rda.ci')->first();
        
        if (!$user) {
            $this->error('Utilisateur non trouvé !');
            return;
        }

        // Assigner le rôle
        $user->assignRole('super-admin');
        
        $this->info('Rôle super-admin assigné à l\'utilisateur avec succès !');
    }
} 