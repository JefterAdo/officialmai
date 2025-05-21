<?php

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VÉRIFICATION DES RESSOURCES DU SLIDER ===\n\n";

// Vérifier si les ressources JavaScript et CSS nécessaires sont présentes
$publicDir = public_path();
$jsDir = $publicDir . '/js';
$cssDir = $publicDir . '/css';

// Vérifier les fichiers JavaScript pour Owl Carousel
$owlJsExists = file_exists($publicDir . '/vendor/owl-carousel/owl.carousel.min.js');
echo "Fichier Owl Carousel JS existe: " . ($owlJsExists ? "OUI" : "NON") . "\n";

// Vérifier les fichiers CSS pour Owl Carousel
$owlCssExists = file_exists($publicDir . '/vendor/owl-carousel/assets/owl.carousel.min.css');
$owlThemeCssExists = file_exists($publicDir . '/vendor/owl-carousel/assets/owl.theme.default.min.css');
echo "Fichier Owl Carousel CSS existe: " . ($owlCssExists ? "OUI" : "NON") . "\n";
echo "Fichier Owl Carousel Theme CSS existe: " . ($owlThemeCssExists ? "OUI" : "NON") . "\n";

// Vérifier si jQuery est inclus
$jqueryExists = file_exists($publicDir . '/vendor/jquery/jquery.min.js');
echo "Fichier jQuery existe: " . ($jqueryExists ? "OUI" : "NON") . "\n\n";

// Vérifier l'inclusion des scripts dans les layouts
$layoutsDir = resource_path('views/layouts');
$layoutFiles = glob($layoutsDir . '/*.blade.php');

echo "=== VÉRIFICATION DES LAYOUTS ===\n\n";

foreach ($layoutFiles as $layoutFile) {
    $layoutContent = file_get_contents($layoutFile);
    $filename = basename($layoutFile);
    
    echo "Layout: {$filename}\n";
    
    // Vérifier si jQuery est inclus
    $jqueryIncluded = strpos($layoutContent, 'jquery') !== false;
    echo "  jQuery inclus: " . ($jqueryIncluded ? "OUI" : "NON") . "\n";
    
    // Vérifier si Owl Carousel est inclus
    $owlIncluded = strpos($layoutContent, 'owl') !== false;
    echo "  Owl Carousel inclus: " . ($owlIncluded ? "OUI" : "NON") . "\n";
    
    // Vérifier si @stack('scripts') est présent
    $stackScriptsPresent = strpos($layoutContent, "@stack('scripts')") !== false;
    echo "  @stack('scripts') présent: " . ($stackScriptsPresent ? "OUI" : "NON") . "\n\n";
}

// Vérifier les problèmes potentiels avec le slider
echo "=== VÉRIFICATION DU COMPOSANT SLIDER ===\n\n";
$sliderComponent = resource_path('views/components/home/slider.blade.php');
$sliderContent = file_get_contents($sliderComponent);

// Vérifier si le slider utilise Owl Carousel correctement
$owlInitialized = strpos($sliderContent, 'owlCarousel') !== false;
echo "Owl Carousel initialisé dans le slider: " . ($owlInitialized ? "OUI" : "NON") . "\n";

// Vérifier si le slider est inclus dans la page d'accueil
$welcomeView = resource_path('views/welcome.blade.php');
$welcomeContent = file_get_contents($welcomeView);
$sliderIncluded = strpos($welcomeContent, 'x-home.slider') !== false;
echo "Slider inclus dans la page d'accueil: " . ($sliderIncluded ? "OUI" : "NON") . "\n\n";

echo "=== TERMINÉ ===\n";
