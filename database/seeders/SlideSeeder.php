<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slide;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Avec le RHDP, ensemble, bâtissons l\'avenir de la Côte d\'Ivoire',
                'description' => 'Grâce au leadership du Président Alassane Ouattara, le RHDP transforme la Côte d\'Ivoire.',
                'image_path' => 'images/Alassane Ouattara_Président.jpg',
                'button_text' => 'J\'adhère',
                'button_link' => '/militer/adhesion',
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Rejoignez le RHDP et devenez acteur du changement.',
                'description' => 'Ensemble, nous tracerons la voie vers un développement durable. Votre adhésion est notre force.',
                'image_path' => 'images/le_RHDP_Côte_d_Ivoire.png',
                'button_text' => null,
                'button_link' => null,
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'La Force d\'une Côte d\'Ivoire Rassemblée',
                'description' => 'Le RHDP rassemble la Côte d\'Ivoire pour une nation unie et forte.',
                'image_path' => 'images/RHDP_1er_Congres_Ordinaire.png',
                'button_text' => 'En savoir plus',
                'button_link' => '#',
                'order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($slides as $slide) {
            Slide::create($slide);
        }
    }
}
