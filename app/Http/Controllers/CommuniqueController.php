<?php

namespace App\Http\Controllers;

use App\Models\Communique;
use App\Models\CommuniqueAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CommuniqueController extends Controller
{
    /**
     * Affiche la liste des communiqués publiés
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $communiques = Communique::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('communiques.index', compact('communiques'));
    }

    /**
     * Affiche un communiqué spécifique
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $communique = Communique::with('attachments')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Si le paramètre download est présent, on redirige vers la méthode de téléchargement
        if (request()->has('download')) {
            $attachmentId = request()->query('attachment');
            return $this->download($communique, $attachmentId);
        }

        return view('communiques.show', compact('communique'));
    }
    
    /**
     * Télécharge un fichier de communiqué
     *
     * @param Communique $communique
     * @param int|null $attachmentId
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function download(Communique $communique, $attachmentId = null)
    {
        // Si un ID de pièce jointe est spécifié, télécharger cette pièce jointe
        if ($attachmentId) {
            $attachment = $communique->attachments()->findOrFail($attachmentId);
            
            return $this->downloadAttachment($attachment);
        }
        
        // Si aucun ID n'est spécifié, vérifier s'il y a une seule pièce jointe
        if ($communique->attachments->count() === 1) {
            $attachment = $communique->attachments->first();
            
            return $this->downloadAttachment($attachment);
        }
        
        // Si plusieurs pièces jointes sont disponibles mais qu'aucun ID n'est spécifié,
        // créer une archive ZIP avec toutes les pièces jointes
        if ($communique->attachments->count() > 1) {
            return $this->downloadAllAttachments($communique);
        }
        
        // Si aucune pièce jointe n'est disponible, rediriger vers la page du communiqué
        return redirect()->route('communiques.show', $communique->slug)
            ->with('warning', 'Aucun fichier n\'est disponible pour ce communiqué.');
    }
    
    /**
     * Télécharge une pièce jointe spécifique
     * 
     * @param CommuniqueAttachment $attachment
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function downloadAttachment(CommuniqueAttachment $attachment)
    {
        $path = $attachment->file_path;
        
        // Vérifier si le fichier existe
        if (!Storage::disk('public')->exists($path)) {
            \Log::warning("Fichier non trouvé : {$path}");
            
            // Essayer avec un chemin alternatif
            $basename = basename($path);
            $altPath = "communiques/documents/{$basename}";
            
            if (Storage::disk('public')->exists($altPath)) {
                \Log::info("Fichier trouvé avec chemin alternatif : {$altPath}");
                $path = $altPath;
            } else {
                abort(404, 'Le fichier demandé n\'existe pas ou a été déplacé.');
            }
        }
        
        // Incrémenter le compteur de téléchargements
        $attachment->increment('download_count');
        
        // Télécharger le fichier
        return Storage::disk('public')->download(
            $path, 
            $attachment->download_name,
            ['Content-Type' => $attachment->mime_type ?? 'application/octet-stream']
        );
    }
    
    /**
     * Télécharge toutes les pièces jointes d'un communiqué en tant qu'archive ZIP
     * 
     * @param Communique $communique
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function downloadAllAttachments(Communique $communique)
    {
        // Créer un nom de fichier temporaire pour le ZIP
        $zipFileName = 'communique-' . $communique->id . '-' . Str::slug(substr($communique->title, 0, 50)) . '.zip';
        $zipFilePath = 'tmp-uploads/' . $zipFileName;
        
        // Créer un nouveau fichier ZIP
        $zip = new \ZipArchive();
        $fullZipPath = Storage::disk('public')->path($zipFilePath);
        
        if ($zip->open($fullZipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Impossible de créer l\'archive ZIP.');
        }
        
        $files = [];
        
        // Ajouter chaque pièce jointe au ZIP
        foreach ($communique->attachments as $attachment) {
            $path = $attachment->file_path;
            
            // Vérifier si le fichier existe
            if (!Storage::disk('public')->exists($path)) {
                // Essayer avec un chemin alternatif
                $basename = basename($path);
                $altPath = "communiques/documents/{$basename}";
                
                if (Storage::disk('public')->exists($altPath)) {
                    $path = $altPath;
                } else {
                    continue; // Ignorer ce fichier s'il n'existe pas
                }
            }
            
            // Chemin complet du fichier
            $fullPath = Storage::disk('public')->path($path);
            
            // Ajouter au ZIP avec le nom original
            $zip->addFile($fullPath, $attachment->download_name);
            
            // Incrémenter le compteur de téléchargements
            $attachment->increment('download_count');
            
            $files[] = $path;
        }
        
        $zip->close();
        
        // Vérifier si l'archive a été créée et contient des fichiers
        if (!Storage::disk('public')->exists($zipFilePath) || count($files) === 0) {
            abort(404, 'Aucun fichier n\'est disponible pour ce communiqué.');
        }
        
        // Télécharger l'archive ZIP
        return Storage::disk('public')->download(
            $zipFilePath, 
            $zipFileName,
            ['Content-Type' => 'application/zip']
        );
    }
    
    /**
     * Supprime une pièce jointe
     *
     * @param  \App\Models\Communique  $communique
     * @param  int  $attachmentId
     * @return \Illuminate\Http\Response
     */
    public function deleteAttachment(Communique $communique, $attachmentId)
    {
        try {
            // Vérifier que l'utilisateur est authentifié et a les droits nécessaires
            if (!auth()->check() || !auth()->user()->can('update', $communique)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Action non autorisée.'
                ], 403);
            }
            
            // Trouver la pièce jointe
            $attachment = $communique->attachments()->findOrFail($attachmentId);
            $filePath = $attachment->file_path;
            
            // Supprimer le fichier du stockage
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            // Supprimer l'enregistrement de la base de données
            $attachment->delete();
            
            // Vérifier si c'est la dernière pièce jointe
            if ($communique->attachments()->count() === 0) {
                // Mettre à jour le statut du communiqué si nécessaire
                $communique->update(['has_attachments' => false]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'La pièce jointe a été supprimée avec succès.'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de la pièce jointe : ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la suppression de la pièce jointe.'
            ], 500);
        }
    }
} 