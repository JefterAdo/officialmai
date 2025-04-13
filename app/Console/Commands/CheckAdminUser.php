<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CheckAdminUser extends Command
{
    protected $signature = 'admin:check';
    protected $description = 'Check admin user details';

    public function handle()
    {
        $user = User::where('email', 'admin@rhdp.ci')->first();

        if (!$user) {
            $this->error('Admin user not found!');
            return 1;
        }

        $this->info('Admin user found:');
        $this->table(
            ['ID', 'Name', 'Email', 'Roles', 'Created At'],
            [[
                $user->id,
                $user->name,
                $user->email,
                $user->roles->pluck('name')->join(', '),
                $user->created_at
            ]]
        );

        return 0;
    }
} 