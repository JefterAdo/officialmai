<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $futureDate = $now->copy()->addMonth();
        
        $events = [
            [
                'title' => 'Assemblée Générale du RHDP',
                'slug' => 'assemblee-generale-rhdp',
                'description' => 'Assemblée générale annuelle du Rassemblement des Houphouëtistes pour la Démocratie et la Paix',
                'start_date' => $futureDate->copy()->addDays(15)->format('Y-m-d 09:00:00'),
                'end_date' => $futureDate->copy()->addDays(15)->format('Y-m-d 17:00:00'),
                'location' => 'Hôtel Ivoire, Abidjan',
                'address' => 'Boulevard de la République',
                'city' => 'Abidjan',
                'country' => 'Côte d\'Ivoire',
                'contact_email' => 'contact@rhdp.ci',
                'contact_phone' => '+225 20 30 40 50',
                'max_participants' => 500,
                'is_public' => true,
                'is_active' => true,
                'featured_image' => 'events/assemblee-generale.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Célébration du 10ème anniversaire du RHDP',
                'slug' => '10-ans-rhdp',
                'description' => 'Célébration du 10ème anniversaire de la création du Rassemblement des Houphouëtistes pour la Démocratie et la Paix',
                'start_date' => $futureDate->copy()->addDays(30)->format('Y-m-d 08:00:00'),
                'end_date' => $futureDate->copy()->addDays(30)->format('Y-m-d 23:59:59'),
                'location' => 'Stade Félix Houphouët-Boigny',
                'address' => 'Boulevard de la Paix',
                'city' => 'Abidjan',
                'country' => 'Côte d\'Ivoire',
                'contact_email' => 'evenements@rhdp.ci',
                'contact_phone' => '+225 20 30 40 60',
                'max_participants' => 5000,
                'is_public' => true,
                'is_active' => true,
                'featured_image' => 'events/anniversaire-rhdp.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->updateOrInsert(
                ['slug' => $event['slug']],
                $event
            );
        }
    }
}
