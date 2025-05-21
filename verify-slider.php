<?php
// Script pour vérifier que tout est bien configuré pour le slider
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Slide;
use Illuminate\Support\Facades\File;

echo "=== VÉRIFICATION COMPLÈTE DU SLIDER ===\n\n";

// 1. Vérifier les slides dans la base de données
echo "1. SLIDES DANS LA BASE DE DONNÉES\n";
$slides = Slide::where('is_active', true)->orderBy('order')->get();
echo "Nombre de slides actifs: " . $slides->count() . "\n";
foreach ($slides as $slide) {
    echo "- ID: {$slide->id}, Titre: {$slide->title}, Image: {$slide->image_path}\n";
    
    // Vérifier si l'image existe
    $imagePath = storage_path('app/public/' . $slide->image_path);
    $exists = file_exists($imagePath) ? "OUI" : "NON";
    echo "  Image existe dans storage/app/public: {$exists}\n";
    
    // Vérifier si l'image existe dans public/storage
    $publicPath = public_path('storage/' . $slide->image_path);
    $publicExists = file_exists($publicPath) ? "OUI" : "NON";
    echo "  Image existe dans public/storage: {$publicExists}\n";
}
echo "\n";

// 2. Vérifier les fichiers de template
echo "2. FICHIERS DE TEMPLATE\n";

// Vérifier welcome.blade.php
$welcomePath = resource_path('views/welcome.blade.php');
$welcomeContent = file_get_contents($welcomePath);
$includesSlider = strpos($welcomeContent, "@include('components.home.slider')") !== false;
echo "welcome.blade.php inclut le composant slider: " . ($includesSlider ? "OUI" : "NON") . "\n";

// Vérifier slider.blade.php
$sliderPath = resource_path('views/components/home/slider.blade.php');
$sliderContent = file_get_contents($sliderPath);
$usesBootstrap = strpos($sliderContent, "position-relative") !== false;
$usesDirectUrls = strpos($sliderContent, "/storage/{{ \$slide->image_path }}") !== false;
echo "slider.blade.php utilise des classes Bootstrap: " . ($usesBootstrap ? "OUI" : "NON") . "\n";
echo "slider.blade.php utilise des URLs directes: " . ($usesDirectUrls ? "OUI" : "NON") . "\n";

// Vérifier app.blade.php
$appPath = resource_path('views/layouts/app.blade.php');
$appContent = file_get_contents($appPath);
$includesJquery = strpos($appContent, "jquery") !== false;
$includesOwlCarousel = strpos($appContent, "owl.carousel") !== false;
echo "app.blade.php inclut jQuery: " . ($includesJquery ? "OUI" : "NON") . "\n";
echo "app.blade.php inclut Owl Carousel: " . ($includesOwlCarousel ? "OUI" : "NON") . "\n";

// 3. Vérifier les fichiers d'images
echo "\n3. FICHIERS D'IMAGES\n";
$slidesDir = storage_path('app/public/slides');
$publicSlidesDir = public_path('storage/slides');

// Lister les images dans storage/app/public/slides
$storageImages = File::files($slidesDir);
echo "Images dans storage/app/public/slides: " . count($storageImages) . "\n";
foreach ($storageImages as $image) {
    $name = $image->getFilename();
    echo "- {$name}\n";
}
echo "\n";

// Lister les images dans public/storage/slides
$publicImages = File::files($publicSlidesDir);
echo "Images dans public/storage/slides: " . count($publicImages) . "\n";
foreach ($publicImages as $image) {
    $name = $image->getFilename();
    echo "- {$name}\n";
}

echo "\n=== RÉSUMÉ DE LA VÉRIFICATION ===\n";
$allGood = 
    $slides->count() > 0 && 
    $includesSlider && 
    $usesBootstrap && 
    $usesDirectUrls && 
    $includesJquery && 
    $includesOwlCarousel && 
    count($storageImages) > 0 && 
    count($publicImages) > 0;

if ($allGood) {
    echo "✅ Tout est correctement configuré pour le slider!\n";
} else {
    echo "❌ Il y a des problèmes dans la configuration du slider.\n";
}

echo "\nTerminé.\n";
