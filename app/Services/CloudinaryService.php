<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    /**
     * Upload un fichier vers Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string URL de l'image
     */
    public function uploadImage(UploadedFile $file, string $folder = 'slides'): string
    {
        $result = Cloudinary::upload($file->getRealPath(), [
            'folder' => $folder,
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]
        ]);
        
        return $result->getSecurePath();
    }
    
    /**
     * Uploader une image depuis un chemin local
     *
     * @param string $path Chemin local de l'image
     * @param string $folder Dossier dans Cloudinary
     * @return string URL de l'image
     */
    public function uploadFromPath(string $path, string $folder = 'slides'): string
    {
        $result = Cloudinary::upload($path, [
            'folder' => $folder,
            'transformation' => [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]
        ]);
        
        return $result->getSecurePath();
    }
    
    /**
     * Supprimer une image de Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    public function deleteImage(string $publicId): bool
    {
        $result = Cloudinary::destroy($publicId);
        return $result->getResult() === 'ok';
    }
    
    /**
     * Extraire l'ID public d'une URL Cloudinary
     *
     * @param string $url
     * @return string|null
     */
    public function getPublicIdFromUrl(string $url): ?string
    {
        if (empty($url) || !is_string($url)) {
            return null;
        }
        
        // Format: https://res.cloudinary.com/cloud_name/image/upload/v1234567890/folder/filename.jpg
        preg_match('/\/v\d+\/(.+)\.\w+$/', $url, $matches);
        return $matches[1] ?? null;
    }
    
    /**
     * Optimiser une URL d'image pour différentes utilisations
     *
     * @param string $url URL Cloudinary
     * @param string $usage Type d'utilisation (slider, thumbnail, etc.)
     * @return string URL optimisée
     */
    public function optimizeUrl(string $url, string $usage = 'default'): string
    {
        if (empty($url) || !is_string($url) || strpos($url, 'cloudinary.com') === false) {
            return $url;
        }
        
        $transformations = [
            'slider' => 'c_fill,g_auto,h_600,w_1600,q_auto,f_auto',
            'thumbnail' => 'c_thumb,g_face,h_200,w_300,q_auto,f_auto',
            'gallery' => 'c_fill,g_auto,h_400,w_600,q_auto,f_auto',
            'default' => 'q_auto,f_auto',
        ];
        
        $transform = $transformations[$usage] ?? $transformations['default'];
        
        // Insérer la transformation dans l'URL
        // Format original: https://res.cloudinary.com/cloud_name/image/upload/v1234567890/folder/filename.jpg
        // Format transformé: https://res.cloudinary.com/cloud_name/image/upload/transformation/v1234567890/folder/filename.jpg
        return preg_replace('/\/upload\//', '/upload/' . $transform . '/', $url);
    }
}
