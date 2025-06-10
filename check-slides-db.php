<?php
// Script pour vérifier les données des slides dans la base de données
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Slide;

echo "=== VÉRIFICATION DES SLIDES DANS LA BASE DE DONNÉES ===\n\n";

// Récupérer tous les slides
$slides = Slide::all();

echo "Nombre total de slides: " . $slides->count() . "\n\n";

foreach ($slides as $slide) {
    echo "ID: {$slide->id}\n";
    echo "Titre: {$slide->title}\n";
    echo "Chemin image: {$slide->image_path}\n";
    echo "Actif: " . ($slide->is_active ? 'OUI' : 'NON') . "\n";
    echo "Ordre: {$slide->order}\n";
    
    // Vérifier si le fichier existe
    $fullPath = storage_path('app/public/' . $slide->image_path);
    echo "Chemin complet: {$fullPath}\n";
    echo "Fichier existe: " . (file_exists($fullPath) ? 'OUI' : 'NON') . "\n";
    
    // Vérifier l'URL
    $url = '/storage/' . $slide->image_path;
    echo "URL: {$url}\n";
    
    echo "----------------------------\n";
}

// Vérifier le composant du slider
echo "\n=== VÉRIFICATION DU COMPOSANT SLIDER ===\n\n";
$sliderPath = resource_path('views/components/home/slider.blade.php');
echo "Chemin du composant: {$sliderPath}\n";
echo "Fichier existe: " . (file_exists($sliderPath) ? 'OUI' : 'NON') . "\n";

if (file_exists($sliderPath)) {
    $content = file_get_contents($sliderPath);
    echo "Contenu (extrait):\n";
    echo "----------------------------\n";
    echo substr($content, 0, 500) . "...\n";
    echo "----------------------------\n";
}

// Vérifier la page d'accueil
echo "\n=== VÉRIFICATION DE LA PAGE D'ACCUEIL ===\n\n";
$welcomePath = resource_path('views/welcome.blade.php');
echo "Chemin de la page d'accueil: {$welcomePath}\n";
echo "Fichier existe: " . (file_exists($welcomePath) ? 'OUI' : 'NON') . "\n";

if (file_exists($welcomePath)) {
    $content = file_get_contents($welcomePath);
    // Rechercher les références au slider
    $includePattern = "/@include\s*\(\s*['\"]components\.home\.slider['\"]\s*\)/i";
    $referencesFound = preg_match($includePattern, $content);

    echo "Référence à @include('components.home.slider') trouvée: " . ($referencesFound ? 'OUI' : 'NON') . "\n";
}

echo "\nTerminé.\n";
