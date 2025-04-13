<?php

namespace App\Filament\Resources\GalleryResource\Pages;

use App\Filament\Resources\GalleryResource;
use App\Models\GalleryImage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGallery extends EditRecord
{
    protected static string $resource = GalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function afterSave(): void
    {
        $gallery = $this->record;
        $images = $this->data['images'] ?? [];
        
        // Si les images sont vides, ne rien faire
        if (empty($images)) {
            return;
        }
        
        // Récupération des images existantes
        $existingImages = $gallery->images->pluck('image_path')->toArray();
        
        // Supprimer toutes les images actuelles
        GalleryImage::where('gallery_id', $gallery->id)->delete();
        
        // Ajouter les images dans l'ordre
        foreach ($images as $index => $image) {
            // Vérifier si l'image est une chaîne de caractères ou un objet
            $imagePath = is_string($image) ? $image : null;
            
            // Si c'est un tableau complexe, essayer de récupérer le chemin
            if (is_array($image) && !empty($image)) {
                // Essayer de récupérer le premier élément qui contient le chemin d'image
                $firstKey = array_key_first($image);
                if (isset($image[$firstKey]) && is_array($image[$firstKey]) && !empty($image[$firstKey])) {
                    $imagePath = is_string($image[$firstKey][0]) ? $image[$firstKey][0] : null;
                }
            }
            
            // Si on a un chemin d'image valide, créer l'entrée
            if ($imagePath) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $imagePath,
                    'order' => $index,
                ]);
            }
        }
    }
}