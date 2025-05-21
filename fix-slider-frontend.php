<?php
// Script pour diagnostiquer et corriger les problèmes d'affichage des images du slider en frontend
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Slide;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

echo "=== DIAGNOSTIC ET RÉPARATION DU SLIDER FRONTEND ===\n\n";

// 1. Vérifier les slides actifs
$slides = Slide::where('is_active', true)->orderBy('order')->get();
echo "1. SLIDES ACTIFS DANS LA BASE DE DONNÉES\n";
echo "Nombre de slides actifs: " . $slides->count() . "\n";

foreach ($slides as $slide) {
    echo "- ID: {$slide->id}, Titre: {$slide->title}, Image: {$slide->image_path}\n";
    
    // Vérifier si l'image existe
    $storagePath = storage_path('app/public/' . $slide->image_path);
    $publicPath = public_path('storage/' . $slide->image_path);
    
    echo "  Image dans storage/app/public: " . (file_exists($storagePath) ? "OUI" : "NON") . "\n";
    echo "  Image dans public/storage: " . (file_exists($publicPath) ? "OUI" : "NON") . "\n";
    
    // Vérifier la taille du fichier
    if (file_exists($storagePath)) {
        $fileSize = filesize($storagePath);
        echo "  Taille du fichier: {$fileSize} octets\n";
        
        // Vérifier les permissions
        $permissions = substr(sprintf('%o', fileperms($storagePath)), -4);
        echo "  Permissions: {$permissions}\n";
        
        // Corriger les permissions si nécessaire
        if ($permissions != "0777") {
            chmod($storagePath, 0777);
            echo "  ✅ Permissions corrigées à 0777\n";
        }
    }
    
    // Copier l'image si elle n'existe pas dans public/storage
    if (file_exists($storagePath) && !file_exists($publicPath)) {
        $publicDir = dirname($publicPath);
        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0777, true);
        }
        
        if (copy($storagePath, $publicPath)) {
            chmod($publicPath, 0777);
            echo "  ✅ Image copiée vers public/storage\n";
        } else {
            echo "  ❌ Échec de la copie vers public/storage\n";
        }
    }
}

// 2. Vérifier le template du slider
echo "\n2. VÉRIFICATION DU TEMPLATE DU SLIDER\n";
$sliderPath = resource_path('views/components/home/slider.blade.php');
$sliderContent = file_get_contents($sliderPath);

// Vérifier si le template utilise l'URL correcte
$correctUrlPattern = "background-image: url('/storage/{{ \$slide->image_path }}')";
if (strpos($sliderContent, $correctUrlPattern) !== false) {
    echo "✅ Le template utilise la bonne syntaxe d'URL\n";
} else {
    echo "❌ Le template n'utilise pas la bonne syntaxe d'URL\n";
    
    // Corriger le template
    $newSliderContent = <<<'BLADE'
@php
$slides = \App\Models\Slide::where('is_active', true)->orderBy('order')->get();
@endphp

<div class="position-relative">
    <div class="owl-carousel slide-carousel">
        @foreach($slides as $slide)
            <div class="position-relative" style="height: 600px; background-image: url('/storage/{{ $slide->image_path }}'); background-size: cover; background-position: center;">
                <div class="position-absolute top-0 start-0 end-0 bottom-0 bg-dark opacity-50"></div>
                <div class="position-relative z-index-1 d-flex flex-column align-items-center justify-content-center h-100 text-white text-center px-4">
                    <h2 class="display-4 fw-bold mb-4">{{ $slide->title }}</h2>
                    @if($slide->description)
                        <p class="fs-4 mb-5 mx-auto" style="max-width: 800px;">{{ $slide->description }}</p>
                    @endif
                    @if($slide->button_text && $slide->button_link)
                        <a href="{{ $slide->button_link }}" class="btn btn-primary btn-lg slider-cta">
                            {{ $slide->button_text }}
                            @if(str_contains($slide->button_text, "J'adhère"))
                                <i class="fas fa-user-plus ms-2"></i>
                            @else
                                <i class="fas fa-info-circle ms-2"></i>
                            @endif
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Navigation Arrows -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
        $(".slide-carousel").owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            responsive: {
                0: {
                    items: 1
                }
            }
        });
    });
</script>
@endpush
BLADE;
    
    file_put_contents($sliderPath, $newSliderContent);
    echo "✅ Template du slider corrigé\n";
}

// 3. Vérifier le layout principal
echo "\n3. VÉRIFICATION DU LAYOUT PRINCIPAL\n";
$layoutPath = resource_path('views/layouts/app.blade.php');
$layoutContent = file_get_contents($layoutPath);

// Vérifier si le layout inclut jQuery et Owl Carousel
$hasJQuery = strpos($layoutContent, 'jquery') !== false;
$hasOwlCarousel = strpos($layoutContent, 'owl.carousel') !== false;

echo "jQuery inclus: " . ($hasJQuery ? "OUI" : "NON") . "\n";
echo "Owl Carousel inclus: " . ($hasOwlCarousel ? "OUI" : "NON") . "\n";

// 4. Créer une version alternative du slider avec des balises img
echo "\n4. CRÉATION D'UNE VERSION ALTERNATIVE DU SLIDER\n";
$alternativeSliderPath = resource_path('views/components/home/slider-alt.blade.php');
$alternativeSliderContent = <<<'BLADE'
@php
$slides = \App\Models\Slide::where('is_active', true)->orderBy('order')->get();
@endphp

<div class="position-relative">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($slides as $index => $slide)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 600px;">
                    <img src="/storage/{{ $slide->image_path }}" class="d-block w-100 h-100 object-fit-cover" alt="{{ $slide->title }}">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center h-100">
                        <div class="bg-dark bg-opacity-50 p-4 rounded" style="width: 80%; max-width: 800px;">
                            <h2 class="display-4 fw-bold mb-4">{{ $slide->title }}</h2>
                            @if($slide->description)
                                <p class="fs-4 mb-5">{{ $slide->description }}</p>
                            @endif
                            @if($slide->button_text && $slide->button_link)
                                <a href="{{ $slide->button_link }}" class="btn btn-primary btn-lg slider-cta">
                                    {{ $slide->button_text }}
                                    @if(str_contains($slide->button_text, "J'adhère"))
                                        <i class="fas fa-user-plus ms-2"></i>
                                    @else
                                        <i class="fas fa-info-circle ms-2"></i>
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
</div>
BLADE;

file_put_contents($alternativeSliderPath, $alternativeSliderContent);
echo "✅ Version alternative du slider créée: components/home/slider-alt.blade.php\n";

// 5. Modifier la page d'accueil pour utiliser le slider alternatif
echo "\n5. MODIFICATION DE LA PAGE D'ACCUEIL\n";
$welcomePath = resource_path('views/welcome.blade.php');
$welcomeContent = file_get_contents($welcomePath);

// Remplacer l'inclusion du slider
$newWelcomeContent = str_replace(
    "@include('components.home.slider')",
    "@include('components.home.slider-alt')",
    $welcomeContent
);

file_put_contents($welcomePath, $newWelcomeContent);
echo "✅ Page d'accueil modifiée pour utiliser le slider alternatif\n";

// 6. Vider les caches
echo "\n6. VIDAGE DES CACHES\n";
system('php artisan cache:clear');
system('php artisan view:clear');
system('php artisan config:clear');
system('php artisan route:clear');

echo "\n=== RÉSUMÉ ===\n";
echo "✅ Images vérifiées et permissions corrigées\n";
echo "✅ Version alternative du slider créée avec des balises img\n";
echo "✅ Page d'accueil modifiée pour utiliser le slider alternatif\n";
echo "✅ Caches vidés\n";
echo "\nTerminé. Veuillez rafraîchir la page d'accueil pour voir les changements.\n";
