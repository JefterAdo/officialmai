<?php

namespace App\Models;

use App\Services\CloudinaryService;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'button_text',
        'button_link',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
    
    /**
     * Obtenir l'URL de l'image optimisée pour le slider
     *
     * @return string
     */
    public function getSliderImageUrl(): string
    {
        if (strpos($this->image_path, 'cloudinary.com') !== false) {
            // C'est une URL Cloudinary, optimiser pour le slider
            $cloudinary = new CloudinaryService();
            return $cloudinary->optimizeUrl($this->image_path, 'slider');
        }
        
        // URL locale, retourner le chemin direct
        return '/storage/' . $this->image_path;
    }
    
    /**
     * Obtenir l'URL de l'image optimisée pour les miniatures
     *
     * @return string
     */
    public function getThumbnailUrl(): string
    {
        if (strpos($this->image_path, 'cloudinary.com') !== false) {
            // C'est une URL Cloudinary, optimiser pour les miniatures
            $cloudinary = new CloudinaryService();
            return $cloudinary->optimizeUrl($this->image_path, 'thumbnail');
        }
        
        // URL locale, retourner le chemin direct
        return '/storage/' . $this->image_path;
    }
}
