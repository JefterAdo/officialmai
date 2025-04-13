<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class CleanExpiredNotifications extends Command
{
    protected $signature = 'notifications:clean';
    protected $description = 'Supprime les notifications expirées';

    public function handle(NotificationService $notificationService): int
    {
        $count = $notificationService->deleteExpired();
        $this->info("$count notifications expirées ont été supprimées.");
        return Command::SUCCESS;
    }
} 