<?php

namespace App\Console\Commands;

use App\Services\YouTubeService;
use Illuminate\Console\Command;

class SyncYouTubeVideos extends Command
{
    protected $signature = 'youtube:sync';

    protected $description = 'Synchronise les dernières vidéos de la chaîne YouTube';

    public function handle(YouTubeService $youtubeService)
    {
        $this->info('Début de la synchronisation des vidéos YouTube...');
        
        try {
            $youtubeService->syncLatestVideos();
            $this->info('Synchronisation terminée avec succès !');
        } catch (\Exception $e) {
            $this->error('Erreur lors de la synchronisation : ' . $e->getMessage());
        }
    }
} 