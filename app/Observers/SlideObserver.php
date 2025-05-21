<?php

namespace App\Observers;

use App\Models\Slide;
use Illuminate\Support\Facades\File;

class SlideObserver
{
    /**
     * Handle the Slide "created" event.
     */
    public function created(Slide $slide): void
    {
        $this->syncFile($slide);
    }

    /**
     * Handle the Slide "updated" event.
     */
    public function updated(Slide $slide): void
    {
        $this->syncFile($slide);
    }

    /**
     * Handle the Slide "deleted" event.
     */
    public function deleted(Slide $slide): void
    {
        // Supprimer le fichier de public/storage si nécessaire
        $publicPath = public_path('storage/' . $slide->image_path);
        if (file_exists($publicPath)) {
            unlink($publicPath);
        }
    }

    /**
     * Synchroniser le fichier de storage/app/public vers public/storage
     */
    private function syncFile(Slide $slide): void
    {
        if (!$slide->image_path) {
            return;
        }

        $sourcePath = storage_path('app/public/' . $slide->image_path);
        $destPath = public_path('storage/' . $slide->image_path);

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