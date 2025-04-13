<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ArticlesSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'title' => 'Le RHDP salue la mémoire de Charles Diby Koffi',
                'slug' => 'le-rhdp-salue-la-memoire-de-charles-diby-koffi',
                'content' => "Le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) a appris avec une profonde tristesse le décès de M. Charles Koffi DIBY, ancien Ministre d'État, ancien Ministre de l'Économie et des Finances, ancien Président du Conseil Économique, Social, Environnemental et Culturel (CESEC).

En cette douloureuse circonstance, le Directoire du RHDP, au nom de tous les militants et sympathisants du Parti, présente ses condoléances les plus attristées à sa famille biologique, à ses proches et à tous les Ivoiriens.

Le RHDP salue la mémoire d'un grand serviteur de l'État, d'un homme de conviction et de devoir qui a marqué de son empreinte la vie politique et économique de notre pays.

Puisse son âme reposer en paix.",
                'image' => 'images/actualites/charles-diby-koffi.jpg',
                'category' => 'communique',
                'is_featured' => true,
                'published_at' => '2023-12-08 10:00:00',
            ],
            [
                'title' => 'Rencontre avec les structures spécialisées du RHDP',
                'slug' => 'rencontre-avec-les-structures-specialisees-du-rhdp',
                'content' => "Le Secrétaire Exécutif du RHDP, M. Cissé Bacongo, a présidé ce jeudi 07 décembre 2023, une importante rencontre avec les structures spécialisées du Parti.

Cette réunion qui s'est tenue au siège du Parti à Cocody, a permis de faire le point des activités menées au cours de l'année 2023 et de définir les orientations pour l'année 2024.

Le Secrétaire Exécutif a salué le dynamisme des structures spécialisées et les a exhortées à maintenir le cap pour l'atteinte des objectifs du Parti.

Il a notamment insisté sur la nécessité de renforcer la mobilisation des militants à la base et de poursuivre le travail de sensibilisation et d'information auprès des populations.

Les responsables des différentes structures ont, à leur tour, présenté leurs bilans respectifs et leurs projets pour l'année à venir.

Cette rencontre s'inscrit dans le cadre du suivi régulier des activités des organes du Parti et témoigne de la volonté du RHDP de maintenir une dynamique constante sur le terrain.",
                'image' => 'images/actualites/reunion-structures-specialisees.jpg',
                'category' => 'vie-du-parti',
                'is_featured' => true,
                'published_at' => '2023-12-07 15:30:00',
            ]
        ];

        foreach ($articles as $article) {
            DB::table('articles')->updateOrInsert(
                ['slug' => $article['slug']],
                array_merge($article, [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])
            );
        }
    }
} 