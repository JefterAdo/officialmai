<?php
// Script pour activer plusieurs slides dans la base de données
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Slide;

echo "=== ACTIVATION DE PLUSIEURS SLIDES ===\n\n";

// Vérifier les images disponibles
$slidesDir = storage_path('app/public/slides');
$images = glob($slidesDir . '/slide_*.{jpg,png,gif}', GLOB_BRACE);

echo "Images disponibles dans le dossier slides:\n";
foreach ($images as $image) {
    echo "- " . basename($image) . "\n";
}
echo "\n";

// Créer ou mettre à jour les slides
$slidesToCreate = [
    [
        'title' => 'Ensemble pour une Côte d\'Ivoire prospère',
        'description' => 'Le RHDP s\'engage pour le développement et la paix en Côte d\'Ivoire',
        'image_path' => 'slides/slide_1.jpg',
        'button_text' => 'En savoir plus',
        'button_link' => '/parti/vision',
        'order' => 1,
        'is_active' => true
    ],
    [
        'title' => 'Au service des Ivoiriens',
        'description' => 'Notre engagement pour l\'avenir de la Côte d\'Ivoire',
        'image_path' => 'slides/slide_2.jpg',
        'button_text' => 'Découvrir nos actions',
        'button_link' => '/actualites',
        'order' => 2,
        'is_active' => true
    ],
    [
        'title' => 'Le RHDP en action',
        'description' => 'Rejoignez-nous pour construire ensemble l\'avenir de la Côte d\'Ivoire',
        'image_path' => 'slides/slide_3.png',
        'button_text' => 'J\'adhère',
        'button_link' => '/militer/adhesion',
        'order' => 3,
        'is_active' => true
    ],
    [
        'title' => 'Alassane Ouattara, Président de la République',
        'description' => 'Un leadership visionnaire pour la Côte d\'Ivoire',
        'image_path' => 'slides/slide_4.jpg',
        'button_text' => 'Biographie',
        'button_link' => '/president/presentation',
        'order' => 4,
        'is_active' => true
    ]
];

// Désactiver tous les slides existants
Slide::query()->update(['is_active' => false]);
echo "Tous les slides existants ont été désactivés.\n\n";

// Créer ou mettre à jour les slides
foreach ($slidesToCreate as $index => $slideData) {
    // Vérifier si l'image existe
    $imagePath = storage_path('app/public/' . $slideData['image_path']);
    if (!file_exists($imagePath)) {
        echo "ERREUR: L'image {$slideData['image_path']} n'existe pas à l'emplacement {$imagePath}\n";
        continue;
    }
    
    // Créer ou mettre à jour le slide
    $slide = Slide::updateOrCreate(
        ['image_path' => $slideData['image_path']],
        $slideData
    );
    
    echo "Slide #{$index} créé/mis à jour avec l'ID {$slide->id} et l'image {$slideData['image_path']}\n";
}

echo "\n=== VÉRIFICATION DES SLIDES ACTIFS ===\n\n";
$activeSlides = Slide::where('is_active', true)->orderBy('order')->get();
echo "Nombre de slides actifs: " . $activeSlides->count() . "\n\n";

foreach ($activeSlides as $slide) {
    echo "ID: {$slide->id}\n";
    echo "Titre: {$slide->title}\n";
    echo "Image: {$slide->image_path}\n";
    echo "Ordre: {$slide->order}\n";
    echo "----------------------------\n";
}

echo "\nTerminé.\n";
