<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $document = Document::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $originalPath = $document->getRawOriginal('file_path');
        
        // Si le chemin est déjà une URL, rediriger vers cette URL
        if (filter_var($originalPath, FILTER_VALIDATE_URL)) {
            return redirect($originalPath);
        }
        
        // Sinon, traiter comme un chemin de fichier local
        $filePath = storage_path('app/public/' . $originalPath);
        
        if (!file_exists($filePath)) {
            // Essayer de construire le chemin à partir du nom du fichier
            $fileName = basename($originalPath);
            $filePath = storage_path('app/public/documents/' . $fileName);
            
            if (!file_exists($filePath)) {
                abort(404, 'Le fichier demandé est introuvable.');
            }
        }

        $fileName = Str::slug($document->title) . '.' . pathinfo($filePath, PATHINFO_EXTENSION);
        
        return response()->download($filePath, $fileName);
    }

    /**
     * Afficher un document dans le navigateur
     * 
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function view($slug)
    {
        $document = Document::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $originalPath = $document->getRawOriginal('file_path');
        
        // Si le chemin est déjà une URL, rediriger vers cette URL
        if (filter_var($originalPath, FILTER_VALIDATE_URL)) {
            return redirect($originalPath);
        }
        
        // Sinon, traiter comme un chemin de fichier local
        $filePath = storage_path('app/public/' . $originalPath);
        
        if (!file_exists($filePath)) {
            // Essayer de construire le chemin à partir du nom du fichier
            $fileName = basename($originalPath);
            $filePath = storage_path('app/public/documents/' . $fileName);
            
            if (!file_exists($filePath)) {
                abort(404, 'Le fichier demandé est introuvable.');
            }
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        ]);
    }
}
