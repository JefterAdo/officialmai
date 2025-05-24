<?php

namespace App\Observers;

use App\Models\Communique;
use App\Models\CommuniqueAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CommuniqueObserver
{
    /**
     * Handle the Communique "created" event.
     */
    public function created(Communique $communique): void
    {
        $this->handleAttachments($communique);
    }

    /**
     * Handle the Communique "updated" event.
     */
    public function updated(Communique $communique): void
    {
        $this->handleAttachments($communique);
    }

    /**
     * Handle the Communique "deleting" event.
     */
    public function deleting(Communique $communique): void
    {
        // Supprimer les pièces jointes associées
        foreach ($communique->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }
    }

    /**
     * Gérer les pièces jointes d'un communiqué
     */
    protected function handleAttachments(Communique $communique): void
    {
        $hasNewAttachments = false;
        
        if (request()->has('attachments')) {
            $attachments = request()->file('attachments');
            
            // Si un seul fichier est téléchargé, le convertir en tableau
            if (!is_array($attachments)) {
                $attachments = [$attachments];
            }

            foreach ($attachments as $file) {
                if (!$file instanceof UploadedFile) {
                    continue;
                }

                $path = $file->store('communiques/documents', 'public');
                
                $communique->attachments()->create([
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'download_count' => 0,
                ]);
                
                $hasNewAttachments = true;
            }
        }
        
        // Mettre à jour le statut des pièces jointes si nécessaire
        if ($hasNewAttachments) {
            $communique->update(['has_attachments' => true]);
        }
    }
}
