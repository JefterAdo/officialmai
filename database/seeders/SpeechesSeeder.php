<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SpeechesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $pastDate = $now->copy()->subMonths(3);
        
        // Créer une catégorie de discours si elle n'existe pas
        $categoryId = DB::table('speech_categories')->insertGetId([
            'name' => 'Discours officiels',
            'slug' => 'discours-officiels',
            'description' => 'Discours officiels des membres du parti',
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        
        $speeches = [
            [
                'speech_category_id' => $categoryId,
                'title' => 'Discours de lancement de la campagne électorale',
                'slug' => 'discours-lancement-campagne',
                'description' => 'Discours prononcé par le Président du RHDP lors du lancement de la campagne électorale',
                'content' => '<p>Discours complet du Président lors du lancement de la campagne électorale du RHDP.</p>',
                'speaker' => 'Alassane Ouattara',
                'event_name' => 'Lancement de la campagne électorale',
                'location' => 'Abidjan',
                'speech_date' => $pastDate->format('Y-m-d'),
                'file_path' => 'speeches/discours-campagne.pdf',
                'file_name' => 'discours-campagne-2025.pdf',
                'mime_type' => 'application/pdf',
                'file_size' => 1024000,
                'video_url' => 'https://youtube.com/embed/example1',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => $pastDate->format('Y-m-d H:i:s'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'speech_category_id' => $categoryId,
                'title' => 'Allocution à l\'occasion de la fête nationale',
                'slug' => 'allocution-fete-nationale',
                'description' => 'Allocution du Secrétaire Général à l\'occasion de la fête nationale',
                'content' => '<p>Allocution complète prononcée à l\'occasion de la fête nationale.</p>',
                'speaker' => 'Henriette Diabaté',
                'event_name' => 'Célébration de la fête nationale',
                'location' => 'Yamoussoukro',
                'speech_date' => $pastDate->copy()->subDays(30)->format('Y-m-d'),
                'file_path' => 'speeches/allocution-fete-nationale.pdf',
                'file_name' => 'allocution-fete-nationale-2025.pdf',
                'mime_type' => 'application/pdf',
                'file_size' => 890000,
                'audio_url' => 'https://example.com/audio/allocution-fete-nationale.mp3',
                'is_featured' => false,
                'is_published' => true,
                'published_at' => $pastDate->copy()->subDays(30)->format('Y-m-d H:i:s'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($speeches as $speech) {
            DB::table('speeches')->updateOrInsert(
                ['slug' => $speech['slug']],
                $speech
            );
        }
    }
}
