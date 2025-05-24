<?php

namespace App\Services;

use App\Models\CommuniqueAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AttachmentService
{
    /**
     * Supprime une pièce jointe et son fichier associé
     *
     * @param  \App\Models\CommuniqueAttachment  $attachment
     * @return bool
     */
    public function deleteAttachment(CommuniqueAttachment $attachment): bool
    {
        try {
            $filePath = $attachment->file_path;
            
            // Supprimer le fichier s'il existe
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            // Supprimer l'enregistrement de la base de données
            $attachment->delete();
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression de la pièce jointe : ' . $e->getMessage());
            return false;
        }
    }
}
