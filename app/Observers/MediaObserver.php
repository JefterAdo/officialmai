<?php

namespace App\Observers;

use App\Models\Media;
use Illuminate\Support\Facades\File;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function created(Media $media): void
    {
        $this->syncFile($media);
    }

    /**
     * Handle the Media "updated" event.
     */
    public function updated(Media $media): void
    {
        $this->syncFile($media);
    }

    /**
     * Handle the Media "deleted" event.
     */
    public function deleted(Media $media): void
    {
        // Supprimer le fichier de public/storage si nécessaire
        $publicPath = public_path('storage/' . $media->file_path);
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }
    }

    /**
     * Synchroniser le fichier de storage/app/public vers public/storage
     */
    private function syncFile(Media $media): void
    {
        if (!$media->file_path) {
            return;
        }

        $sourcePath = storage_path('app/public/' . $media->file_path);
        $destPath = public_path('storage/' . $media->file_path);

        // Créer le dossier de destination si nécessaire
        $destDir = dirname($destPath);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0777, true);
        }

        // Copier le fichier
        if (file_exists($sourcePath)) {
            copy($sourcePath, $destPath);
            chmod($destPath, 0777);
        }
    }
}