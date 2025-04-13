<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password';
    protected $description = 'Reset the admin password';

    public function handle()
    {
        $user = User::where('email', 'admin@rhdp.ci')->first();

        if (!$user) {
            $this->error('Admin user not found!');
            return 1;
        }

        $password = 'password123';
        $user->password = bcrypt($password);
        $user->save();

        $this->info('Admin password has been reset to: ' . $password);
        return 0;
    }
} 