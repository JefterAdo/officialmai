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
Route::middleware(['web'])->group(function () {
    // Routes pour les communiqués (à placer avant les routes génériques)
    Route::delete('/communiques/{communique}/attachments/{attachment}', [CommuniqueController::class, 'deleteAttachment'])
        ->name('communiques.attachments.destroy')
        ->middleware(['auth']);

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
        Route::get('/audio', function () {
            return view('mediatheque.audio');
        })->name('audio');
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

    // Routes pour les documents
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('{slug}/download', [DocumentController::class, 'download'])->name('download');
        Route::get('{slug}/view', [DocumentController::class, 'view'])->name('view');
    });

    // Routes pour les pages (à placer en dernier car elles sont génériques)
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
});
