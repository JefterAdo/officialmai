<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            // Page d'accueil
            [
                'title' => 'Accueil',
                'slug' => 'accueil',
                'content' => file_get_contents(resource_path('views/welcome.blade.php')),
                'meta_title' => 'Accueil - RHDP',
                'meta_description' => 'Bienvenue sur le site officiel du RHDP - Rassemblement des Houphouëtistes pour la Démocratie et la Paix',
                'layout' => 'full-width',
                'template' => 'welcome',
                'order' => 1,
                'is_published' => true,
            ],

            // Section Houphouët
            [
                'title' => 'Biographie de Félix Houphouët-Boigny',
                'slug' => 'houphouet/biographie',
                'content' => file_get_contents(resource_path('views/houphouet/biographie.blade.php')),
                'meta_title' => 'Biographie de Félix Houphouët-Boigny - Père de la Nation Ivoirienne | RHDP',
                'meta_description' => 'Découvrez la vie et l\'héritage de Félix Houphouët-Boigny, premier Président de la Côte d\'Ivoire et figure emblématique du RHDP.',
                'layout' => 'sidebar',
                'template' => 'houphouet.biographie',
                'category' => 'houphouet',
                'order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Chronologie',
                'slug' => 'houphouet/chronologie',
                'content' => file_get_contents(resource_path('views/houphouet/chronologie.blade.php')),
                'meta_title' => 'Chronologie - Félix Houphouët-Boigny | RHDP',
                'meta_description' => 'Chronologie détaillée de la vie de Félix Houphouët-Boigny',
                'layout' => 'sidebar',
                'template' => 'houphouet.chronologie',
                'category' => 'houphouet',
                'order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Discours d\'Houphouët-Boigny',
                'slug' => 'houphouet/discours',
                'content' => file_get_contents(resource_path('views/houphouet/discours.blade.php')),
                'meta_title' => 'Discours - Félix Houphouët-Boigny | RHDP',
                'meta_description' => 'Les discours marquants de Félix Houphouët-Boigny',
                'layout' => 'sidebar',
                'template' => 'houphouet.discours',
                'category' => 'houphouet',
                'order' => 4,
                'is_published' => true,
            ],

            // Section Parti
            [
                'title' => 'Vision du Parti',
                'slug' => 'parti/vision',
                'content' => file_get_contents(resource_path('views/parti/vision.blade.php')),
                'meta_title' => 'Vision - RHDP',
                'meta_description' => 'Découvrez la vision et les valeurs du RHDP',
                'layout' => 'full-width',
                'template' => 'parti.vision',
                'category' => 'parti',
                'order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Organisation du Parti',
                'slug' => 'parti/organisation',
                'content' => file_get_contents(resource_path('views/parti/organisation.blade.php')),
                'meta_title' => 'Organisation - RHDP',
                'meta_description' => 'Structure et organisation du RHDP',
                'layout' => 'full-width',
                'template' => 'parti.organisation',
                'category' => 'parti',
                'order' => 6,
                'is_published' => true,
            ],
            [
                'title' => 'Découvrir le RHDP',
                'slug' => 'parti/decouvrir',
                'content' => file_get_contents(resource_path('views/parti/decouvrir.blade.php')),
                'meta_title' => 'Découvrir - RHDP',
                'meta_description' => 'Tout savoir sur le RHDP',
                'layout' => 'sidebar',
                'template' => 'parti.decouvrir',
                'category' => 'parti',
                'order' => 7,
                'is_published' => true,
            ],

            // Section Militer
            [
                'title' => 'Adhésion',
                'slug' => 'militer/adhesion',
                'content' => file_get_contents(resource_path('views/militer/adhesion.blade.php')),
                'meta_title' => 'Adhésion - RHDP',
                'meta_description' => 'Rejoignez le RHDP',
                'layout' => 'full-width',
                'template' => 'militer.adhesion',
                'category' => 'militer',
                'order' => 8,
                'is_published' => true,
            ],
            [
                'title' => 'Nos Propositions',
                'slug' => 'militer/propositions',
                'content' => file_get_contents(resource_path('views/militer/propositions.blade.php')),
                'meta_title' => 'Propositions - RHDP',
                'meta_description' => 'Les propositions du RHDP pour la Côte d\'Ivoire',
                'layout' => 'sidebar',
                'template' => 'militer.propositions',
                'category' => 'militer',
                'order' => 9,
                'is_published' => true,
            ],

            // Section Médiathèque
            [
                'title' => 'Galerie Photos',
                'slug' => 'mediatheque/photos',
                'content' => file_get_contents(resource_path('views/mediatheque/photos.blade.php')),
                'meta_title' => 'Galerie Photos - RHDP',
                'meta_description' => 'Photos des événements et activités du RHDP',
                'layout' => 'full-width',
                'template' => 'mediatheque.photos',
                'category' => 'mediatheque',
                'order' => 10,
                'is_published' => true,
            ],
            [
                'title' => 'Vidéothèque',
                'slug' => 'mediatheque/videos',
                'content' => file_get_contents(resource_path('views/mediatheque/videos.blade.php')),
                'meta_title' => 'Vidéothèque - RHDP',
                'meta_description' => 'Vidéos des événements et activités du RHDP',
                'layout' => 'full-width',
                'template' => 'mediatheque.videos',
                'category' => 'mediatheque',
                'order' => 11,
                'is_published' => true,
            ],
            [
                'title' => 'Audiothèque',
                'slug' => 'mediatheque/audio',
                'content' => file_get_contents(resource_path('views/mediatheque/audio.blade.php')),
                'meta_title' => 'Audiothèque - RHDP',
                'meta_description' => 'Archives audio du RHDP',
                'layout' => 'sidebar',
                'template' => 'mediatheque.audio',
                'category' => 'mediatheque',
                'order' => 12,
                'is_published' => true,
            ],
            [
                'title' => 'Discours',
                'slug' => 'mediatheque/discours',
                'content' => file_get_contents(resource_path('views/mediatheque/discours.blade.php')),
                'meta_title' => 'Discours - RHDP',
                'meta_description' => 'Archives des discours du RHDP',
                'layout' => 'sidebar',
                'template' => 'mediatheque.discours',
                'category' => 'mediatheque',
                'order' => 13,
                'is_published' => true,
            ],

            // Pages génériques
            [
                'title' => 'À propos',
                'slug' => 'a-propos',
                'content' => '<h1>À propos de nous</h1><p>Contenu de la page à propos...</p>',
                'meta_title' => 'À propos - RHDP',
                'meta_description' => 'En savoir plus sur le RHDP',
                'layout' => 'sidebar',
                'template' => 'default',
                'order' => 14,
                'is_published' => true,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => '<h1>Contactez-nous</h1><p>Contenu de la page de contact...</p>',
                'meta_title' => 'Contact - RHDP',
                'meta_description' => 'Contactez le RHDP',
                'layout' => 'full-width',
                'template' => 'default',
                'order' => 15,
                'is_published' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
} 