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

        return view('mediatheque.communiques.index', compact('communiques'));
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

        return view('mediatheque.communiques.show', compact('communique'));
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
            
            // Vérifier que le fichier existe
            if (!Storage::disk('public')->exists($attachment->file_path)) {
                abort(404, 'Le fichier demandé n\'existe pas.');
            }
            
            // Incrémenter le compteur de téléchargements
            $attachment->increment('download_count');
            
            // Télécharger le fichier
            return Storage::disk('public')->download(
                $attachment->file_path, 
                $attachment->download_name
            );
        }
        
        // Si aucun ID n'est spécifié, vérifier s'il y a une seule pièce jointe
        if ($communique->attachments->count() === 1) {
            $attachment = $communique->attachments->first();
            
            // Vérifier que le fichier existe
            if (!Storage::disk('public')->exists($attachment->file_path)) {
                abort(404, 'Le fichier demandé n\'existe pas.');
            }
            
            // Incrémenter le compteur de téléchargements
            $attachment->increment('download_count');
            
            // Télécharger le fichier
            return Storage::disk('public')->download(
                $attachment->file_path, 
                $attachment->download_name
            );
        }
        
        // Si plusieurs pièces jointes sont disponibles, rediriger vers la page du communiqué
        return redirect()->route('mediatheque.communiques.show', $communique->slug);
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