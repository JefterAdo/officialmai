<?php

namespace App\Console\Commands;

use App\Models\Slide;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateTestSlide extends Command
{
    protected $signature = 'slide:test';
    protected $description = 'Créer un slide test';

    public function handle()
    {
        // Vérifier si l'image source existe
        $sourceImage = 'slides/01JSFXECZFTS0N313N7023YGZ7.jpg';
        if (!Storage::disk('public')->exists($sourceImage)) {
            $this->error('Image source non trouvée !');
            return;
        }

        // Copier l'image
        $newImage = 'slides/test_slide_' . time() . '.jpg';
        Storage::disk('public')->copy($sourceImage, $newImage);

        // Créer le slide
        $slide = Slide::create([
            'title' => 'Ensemble, Construisons l\'Avenir',
            'description' => 'Rejoignez-nous dans notre engagement pour une Côte d\'Ivoire prospère et unie.',
            'image_path' => $newImage,
            'button_text' => 'En savoir plus',
            'button_link' => '/parti/vision',
            'is_active' => true,
            'order' => 0
        ]);

        $this->info('Slide test créé avec succès !');
        $this->info('Image : ' . $newImage);
    }
} 