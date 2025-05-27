<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Communique extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_published',
        'has_attachments',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'has_attachments' => 'boolean',
    ];

    protected $appends = ['file_url', 'human_file_size', 'file_path', 'file_type'];

    /**
     * Obtenir les pièces jointes du communiqué
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(CommuniqueAttachment::class);
    }

    /**
     * Obtenir l'URL du premier fichier attaché (pour rétrocompatibilité)
     */
    public function getFileUrlAttribute()
    {
        $attachment = $this->attachments()->first();
        return $attachment ? $attachment->full_url : null;
    }

    /**
     * Obtenir la taille du premier fichier au format lisible (pour rétrocompatibilité)
     */
    public function getHumanFileSizeAttribute()
    {
        $attachment = $this->attachments()->first();
        if (!$attachment) return null;
        
        $size = intval($attachment->size);
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    /**
     * Obtenir le chemin du premier fichier attaché.
     */
    public function getFilePathAttribute()
    {
        $attachment = $this->attachments()->first();
        return $attachment ? $attachment->file_path : null;
    }

    /**
     * Obtenir le type du premier fichier attaché.
     */
    public function getFileTypeAttribute()
    {
        $attachment = $this->attachments()->first();
        return $attachment ? $attachment->file_type : null;
    }

    /**
     * Supprimer les pièces jointes lors de la suppression du communiqué
     */
    protected static function booted()
    {
        static::deleting(function ($communique) {
            if ($communique->isForceDeleting()) {
                // Supprimer les fichiers physiques
                foreach ($communique->attachments as $attachment) {
                    if (Storage::disk('public')->exists($attachment->file_path)) {
                        Storage::disk('public')->delete($attachment->file_path);
                    }
                }
                
                // Supprimer les enregistrements de la base de données
                $communique->attachments()->delete();
                
                // Mettre à jour le statut des pièces jointes
                $communique->update(['has_attachments' => false]);
            }
        });
        
        // Mettre à jour le statut des pièces jointes après la suppression d'un soft delete
        static::deleted(function ($communique) {
            if ($communique->attachments()->count() === 0) {
                $communique->update(['has_attachments' => false]);
            }
        });
    }
} 