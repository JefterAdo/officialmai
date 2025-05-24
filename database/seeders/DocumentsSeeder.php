<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        
        $documents = [
            [
                'title' => 'Statuts du RHDP',
                'slug' => 'statuts-du-rhdp',
                'file_path' => 'documents/statuts-rhdp.pdf',
                'type' => 'statut',
                'description' => 'Document officiel des statuts du Rassemblement des Houphouëtistes pour la Démocratie et la Paix',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Règlement Intérieur du RHDP',
                'slug' => 'reglement-interieur-rhdp',
                'file_path' => 'documents/reglement-interieur-rhdp.pdf',
                'type' => 'reglement-interieur',
                'description' => 'Règlement intérieur du Rassemblement des Houphouëtistes pour la Démocratie et la Paix',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($documents as $document) {
            DB::table('documents')->updateOrInsert(
                ['slug' => $document['slug']],
                $document
            );
        }
    }
}
