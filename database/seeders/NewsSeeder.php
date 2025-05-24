<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run()
    {
        // Récupérer l'ID de la catégorie Actualités
        $categoryId = DB::table('categories')->where('slug', 'actualites')->value('id');
        
        if (!$categoryId) {
            $this->command->error('La catégorie Actualités n\'existe pas. Veuillez d\'abord exécuter CategoriesSeeder.');
            return;
        }

        $news = [
            [
                'title' => 'Le RHDP célèbre ses 10 ans d\'existence',
                'slug' => 'le-rhdp-celebre-ses-10-ans-d-existence',
                'content' => 'Le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) a célébré ses 10 ans d\'existence ce samedi. Une cérémonie grandiose a été organisée à cet effet au Palais de la Culture de Treichville, en présence de plusieurs personnalités politiques et de milliers de militants.',
                'excerpt' => 'Le RHDP célèbre une décennie d\'engagement politique et de réalisations pour la Côte d\'Ivoire.',
                'featured_image' => 'images/actualites/anniversaire-rhdp.jpg',
                'category_id' => $categoryId,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Lancement des travaux de construction du pont d\'Adiaké',
                'slug' => 'lancement-des-travaux-du-pont-d-adiake',
                'content' => 'Le Premier Ministre Patrick Achi a procédé ce jour au lancement officiel des travaux de construction du pont d\'Adiaké. Ce projet structurant permettra de désenclaver la région et de renforcer les échanges économiques.',
                'excerpt' => 'Un nouveau pont pour désenclaver la région d\'Adiaké et stimuler son économie.',
                'featured_image' => 'images/actualites/pont-adiake.jpg',
                'category_id' => $categoryId,
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Le RHDP forme ses jeunes militants au leadership politique',
                'slug' => 'formation-des-jeunes-militants-rhdp',
                'content' => 'Dans le cadre du renforcement des capacités de ses militants, le RHDP a organisé une session de formation en leadership politique à l\'attention des jeunes du parti. Cette formation s\'est tenue sur trois jours et a rassemblé plus de 200 participants venus de toutes les régions du pays.',
                'excerpt' => 'Plus de 200 jeunes militants formés aux techniques de leadership politique.',
                'featured_image' => 'images/actualites/formation-jeunes.jpg',
                'category_id' => $categoryId,
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
        ];

        foreach ($news as $item) {
            DB::table('news')->insert([
                'title' => $item['title'],
                'slug' => $item['slug'],
                'content' => $item['content'],
                'excerpt' => $item['excerpt'],
                'featured_image' => $item['featured_image'],
                'category_id' => $item['category_id'],
                'is_published' => $item['is_published'],
                'published_at' => $item['published_at'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
