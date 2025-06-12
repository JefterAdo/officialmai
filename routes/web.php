<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CommuniqueController;
use App\Http\Controllers\SpeechController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Mediatheque\PhotoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

// Les routes d'authentification pour le panel admin sont maintenant gérées par Filament
// via App\Filament\Pages\Auth\Login.php et la configuration dans AdminPanelProvider.

// Application des middlewares globaux
Route::middleware(['web', 'throttle:60,1'])->group(function () {
    // Groupe principal pour toutes les routes
    // Routes d'administration nécessitant une authentification
    Route::middleware(['auth', 'verified', 'signed'])->group(function () {
        // Routes pour les communiqués nécessitant une authentification
        Route::delete('/communiques/{communique}/attachments/{attachment}', [CommuniqueController::class, 'deleteAttachment'])
            ->name('communiques.attachments.destroy');
    });

    // Routes pour les communiqués (maintenant autonome)
    Route::get('/communiques', [CommuniqueController::class, 'index'])->name('communiques.index');
    Route::get('/communiques/{slug}', [CommuniqueController::class, 'show'])->name('communiques.show');

    // Routes pour les actualités
    Route::get('/actualites', [NewsController::class, 'index'])->name('actualites.index');
    Route::get('/actualites/categorie/{slug}', [NewsController::class, 'category'])->name('actualites.category');
    Route::get('/actualites/{slug}', [NewsController::class, 'show'])->name('actualites.show');

    // Routes pour Houphouët-Boigny
    Route::get('/houphouet/chronologie', function () {
        return view('houphouet.chronologie');
    })->name('houphouet.chronologie');

    Route::get('/houphouet/biographie', function () {
        return view('houphouet.biographie');
    })->name('houphouet.biographie');

    // Routes pour la section "Le Président"
    Route::prefix('president')->group(function () {
        Route::get('/presentation', function () {
            return view('president.presentation');
        })->name('president.presentation');
    });

    // Routes pour le Parti
    Route::get('/parti/decouvrir', function () {
        return view('parti.decouvrir');
    })->name('parti.decouvrir');

    Route::get('/parti/vision', function () {
        return view('parti.vision');
    })->name('parti.vision');

    Route::get('/parti/organisation', function () {
        return view('parti.organisation');
    })->name('parti.organisation');

    // Routes pour Militer
    Route::get('/militer/adhesion', function () {
        return view('militer.adhesion');
    })->name('militer.adhesion');

    Route::get('/militer/propositions', function () {
        return view('militer.propositions');
    })->name('militer.propositions');

    // Routes pour la Médiathèque
    Route::prefix('mediatheque')->name('mediatheque.')->group(function () {
        // Route::get('/communiques', [CommuniqueController::class, 'index'])->name('communiques'); // Déplacé
        // Route::get('/communiques/{slug}', [CommuniqueController::class, 'show'])->name('communiques.show'); // Déplacé
        Route::get('/videos', [VideoController::class, 'index'])->name('videos');
        Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
        Route::get('/photos', [PhotoController::class, 'index'])->name('photos');
        Route::get('/photos/{gallery:slug}', [PhotoController::class, 'show'])->name('photos.show');
        Route::get('/discours', [SpeechController::class, 'index'])->name('discours');
        Route::get('/discours/{slug}', [SpeechController::class, 'show'])->name('discours.show');
        // Route::get('/audio', function () {
        //     return view('mediatheque.audio');
        // })->name('audio'); // Désactivé temporairement
        Route::get('/textes', [\App\Http\Controllers\Mediatheque\OfficialTextsController::class, 'index'])->name('textes');
    });

    // Routes pour la newsletter
    Route::prefix('newsletter')->name('newsletter.')->group(function () {
        Route::get('subscribe', [NewsletterController::class, 'showSubscriptionForm'])->name('form');
        Route::post('subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
        Route::get('unsubscribe/{subscriber}', [NewsletterController::class, 'unsubscribe'])->name('unsubscribe');
        Route::get('track/open/{campaign}/{subscriber}', [NewsletterController::class, 'trackOpen'])->name('track.open');
        Route::get('track/click/{campaign}/{subscriber}/{link}', [NewsletterController::class, 'trackClick'])->name('track.click');
    });

    // Routes spécifiques pour les conditions générales et la politique de confidentialité
    Route::get('/conditions-generales', function () {
        return view('pages.terms');
    })->name('terms');

    Route::get('/politique-de-confidentialite', function () {
        return view('pages.privacy');
    })->name('privacy');

    // Routes pour les documents avec limitation de débit pour éviter les abus
    Route::prefix('documents')->name('documents.')->middleware(['throttle:30,1'])->group(function () {
        // Route de téléchargement simplifiée
        Route::get('{slug}/download', function($slug) {
            try {
                $document = \App\Models\Document::where('slug', $slug)->firstOrFail();
                $path = $document->getRawOriginal('file_path');
                $filename = basename($path);
                
                // Vérifier si le fichier existe dans le répertoire documents
                $fullPath = storage_path('app/public/documents/' . $filename);
                if (file_exists($fullPath)) {
                    return response()->download($fullPath, $filename);
                }
                
                // Si le fichier n'existe pas, essayer avec le chemin original
                $originalPath = storage_path('app/public/' . $path);
                if (file_exists($originalPath)) {
                    return response()->download($originalPath, $filename);
                }
                
                return back()->with('error', 'Le fichier demandé n\'est pas disponible.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Erreur lors du téléchargement du document', [
                    'error' => $e->getMessage(),
                    'slug' => $slug
                ]);
                return back()->with('error', 'Une erreur est survenue lors du téléchargement du document.');
            }
        })->name('download');
        
        Route::get('{slug}/view', [DocumentController::class, 'view'])->name('view');
    });

    // Temporary debug route to check documents
    Route::get('/debug/documents', function() {
        $documents = \App\Models\Document::all();
        return response()->json([
            'count' => $documents->count(),
            'documents' => $documents->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'slug' => $doc->slug,
                    'type' => $doc->type,
                    'is_active' => $doc->is_active,
                    'file_path' => $doc->file_path,
                ];
            })
        ]);
    });

    // Route pour la recherche
    Route::get('/recherche', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');

    // Routes pour les pages (à placer en dernier car elles sont génériques)
    Route::get('/', [PageController::class, 'home'])->name('home');
    
    // Utiliser une expression régulière pour limiter les caractères valides dans le slug
    // Cela empêche les injections de chemin et autres attaques
    Route::get('/{slug}', [PageController::class, 'show'])
        ->where('slug', '[a-z0-9\-]+') // Uniquement des lettres minuscules, chiffres et tirets
        ->name('page.show');
});
