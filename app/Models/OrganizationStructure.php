<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationStructure extends Model
{
    use HasFactory;

    protected $table = 'organization_structure';

    protected $fillable = [
        'name',
        'title',
        'description',
        'image',
        'role',
        'group',
        'level',
        'parent_id',
        'order',
        'is_active',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-member.jpg');
        }

        // Si l'image commence par 'images/', c'est une ancienne image
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        // Si l'image est une URL complète
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Pour les images dans le stockage public
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        // Pour les images dans le dossier membres
        if (Storage::disk('public')->exists('membres/' . $this->image)) {
            return Storage::disk('public')->url('membres/' . $this->image);
        }

        // Si l'image n'est pas trouvée, retourner l'image par défaut
        return asset('images/default-member.jpg');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->image && !str_starts_with($model->image, 'images/') && !filter_var($model->image, FILTER_VALIDATE_URL)) {
                // Assurez-vous que l'image est dans le bon dossier
                if (!str_starts_with($model->image, 'membres/')) {
                    $model->image = 'membres/' . $model->image;
                }
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(OrganizationStructure::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(OrganizationStructure::class, 'parent_id');
    }

    public function members()
    {
        return $this->hasMany(OrganizationMember::class);
    }
}
