<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\FileSecurityService;
use App\Services\DocumentValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    /**
     * Télécharger un document
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function download($slug)
    {
        try {
            // Récupérer le document actif
            $document = Document::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
            
            // Journaliser la tentative de téléchargement
            Log::info('Tentative de téléchargement de document', [
                'document_id' => $document->id,
                'document_title' => $document->title,
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);

            // Récupérer le chemin original du fichier
            $originalPath = $document->getRawOriginal('file_path');
            
            // Si c'est une URL externe, vérifier qu'elle est sécurisée
            if (filter_var($originalPath, FILTER_VALIDATE_URL)) {
                // Vérifier que l'URL est sécurisée et provient d'un domaine autorisé
                if (!FileSecurityService::isSecureUrl($originalPath)) {
                    Log::warning('Tentative de téléchargement d\'une URL non sécurisée', [
                        'document_id' => $document->id,
                        'url' => $originalPath,
                        'user_id' => auth()->id(),
                        'ip' => request()->ip()
                    ]);
                    return back()->with('error', 'L\'URL du document n\'est pas sécurisée.');
                }
                
                if (!FileSecurityService::isAllowedDomain($originalPath)) {
                    Log::warning('Tentative de téléchargement depuis un domaine non autorisé', [
                        'document_id' => $document->id,
                        'url' => $originalPath,
                        'user_id' => auth()->id(),
                        'ip' => request()->ip()
                    ]);
                    return back()->with('error', 'Le domaine de l\'URL n\'est pas autorisé.');
                }
                
                // Incrémenter le compteur de téléchargements
                $document->increment('download_count');
                
                // Rediriger vers l'URL externe
                return redirect($originalPath);
            }

            // Vérifier si le chemin est sécurisé
            if (!FileSecurityService::isSecurePath($originalPath)) {
                Log::warning('Tentative de téléchargement avec un chemin non sécurisé', [
                    'document_id' => $document->id,
                    'path' => $originalPath,
                    'user_id' => auth()->id(),
                    'ip' => request()->ip()
                ]);
                return back()->with('error', 'Le chemin du fichier n\'est pas sécurisé.');
            }

            // Trouver le fichier, éventuellement dans un chemin alternatif
            $path = FileSecurityService::findAlternativePath($originalPath);
            
            if (!$path) {
                Log::warning('Fichier non trouvé pour téléchargement', [
                    'document_id' => $document->id,
                    'path' => $originalPath,
                    'user_id' => auth()->id(),
                    'ip' => request()->ip()
                ]);
                return back()->with('error', 'Le fichier demandé n\'est pas disponible.');
            }
            
            // Incrémenter le compteur de téléchargements
            $document->increment('download_count');
            
            // Générer un nom de fichier sécurisé pour le téléchargement
            $downloadName = FileSecurityService::generateSecureFilename(
                basename($path),
                pathinfo($path, PATHINFO_EXTENSION)
            );

            // Télécharger le fichier
            return Storage::disk('public')->download($path, $downloadName);
        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement du document', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'slug' => $slug,
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);
            return back()->with('error', 'Une erreur est survenue lors du téléchargement du document.');
        }
    }

    /**
     * Afficher un document dans le navigateur
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function view($slug)
    {
        try {
            // Récupérer le document actif
            $document = Document::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
            
            // Journaliser la tentative de visualisation
            Log::info('Tentative de visualisation de document', [
                'document_id' => $document->id,
                'document_title' => $document->title,
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);

            // Récupérer le chemin original du fichier
            $originalPath = $document->getRawOriginal('file_path');
            
            // Si c'est une URL externe, vérifier qu'elle est sécurisée
            if (filter_var($originalPath, FILTER_VALIDATE_URL)) {
                // Vérifier que l'URL est sécurisée et provient d'un domaine autorisé
                if (!FileSecurityService::isSecureUrl($originalPath)) {
                    Log::warning('Tentative de visualisation d\'une URL non sécurisée', [
                        'document_id' => $document->id,
                        'url' => $originalPath,
                        'user_id' => auth()->id(),
                        'ip' => request()->ip()
                    ]);
                    return back()->with('error', 'L\'URL du document n\'est pas sécurisée.');
                }
                
                if (!FileSecurityService::isAllowedDomain($originalPath)) {
                    Log::warning('Tentative de visualisation depuis un domaine non autorisé', [
                        'document_id' => $document->id,
                        'url' => $originalPath,
                        'user_id' => auth()->id(),
                        'ip' => request()->ip()
                    ]);
                    return back()->with('error', 'Le domaine de l\'URL n\'est pas autorisé.');
                }
                
                // Incrémenter le compteur de visualisations
                $document->increment('view_count');
                
                // Rediriger vers l'URL externe
                return redirect($originalPath);
            }

            // Vérifier si le chemin est sécurisé
            if (!FileSecurityService::isSecurePath($originalPath)) {
                Log::warning('Tentative de visualisation avec un chemin non sécurisé', [
                    'document_id' => $document->id,
                    'path' => $originalPath,
                    'user_id' => auth()->id(),
                    'ip' => request()->ip()
                ]);
                return back()->with('error', 'Le chemin du fichier n\'est pas sécurisé.');
            }

            // Trouver le fichier, éventuellement dans un chemin alternatif
            $path = FileSecurityService::findAlternativePath($originalPath);
            
            if (!$path) {
                Log::warning('Fichier non trouvé pour visualisation', [
                    'document_id' => $document->id,
                    'path' => $originalPath,
                    'user_id' => auth()->id(),
                    'ip' => request()->ip()
                ]);
                return back()->with('error', 'Le fichier demandé n\'est pas disponible.');
            }
            
            // Incrémenter le compteur de visualisations
            $document->increment('view_count');
            
            // Récupérer le type MIME du fichier
            $mimeType = Storage::disk('public')->mimeType($path);
            
            // Vérifier que le type MIME est autorisé
            if (!FileSecurityService::isAllowedMimeType($mimeType)) {
                Log::warning('Tentative de visualisation d\'un fichier avec un type MIME non autorisé', [
                    'document_id' => $document->id,
                    'path' => $path,
                    'mime_type' => $mimeType,
                    'user_id' => auth()->id(),
                    'ip' => request()->ip()
                ]);
                return back()->with('error', 'Le type de fichier n\'est pas autorisé pour la visualisation.');
            }
            
            // Pour les fichiers PDF et images, utiliser une réponse en streaming pour éviter les problèmes de mémoire
            if (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'])) {
                $response = new StreamedResponse(function() use ($path) {
                    $stream = Storage::disk('public')->readStream($path);
                    fpassthru($stream);
                    if (is_resource($stream)) {
                        fclose($stream);
                    }
                });
                
                $response->headers->set('Content-Type', $mimeType);
                $response->headers->set('Content-Disposition', 'inline; filename="' . basename($path) . '"');
                $response->headers->set('Cache-Control', 'public, max-age=3600');
                $response->headers->set('X-Content-Type-Options', 'nosniff'); // Empêche le MIME-sniffing
                $response->headers->set('Content-Security-Policy', "default-src 'self'; frame-ancestors 'self';"); // Protection contre les attaques XSS
                $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Protection contre le clickjacking
                
                return $response;
            }
            
            // Pour les autres types de fichiers, utiliser une réponse standard
            $content = Storage::disk('public')->get($path);
            
            return Response::make($content, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
                'Cache-Control' => 'public, max-age=3600',
                'X-Content-Type-Options' => 'nosniff',
                'Content-Security-Policy' => "default-src 'self'; frame-ancestors 'self';",
                'X-Frame-Options' => 'SAMEORIGIN'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage du document', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'slug' => $slug,
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);
            return back()->with('error', 'Une erreur est survenue lors de l\'affichage du document.');
        }
    }
}
