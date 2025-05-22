<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'file_path',
        'type',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = Str::slug($document->title);
            }
        });
    }

    public function getFilePathAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getTypeLabelAttribute()
    {
        return [
            'statut' => 'Statut',
            'reglement-interieur' => 'Règlement Intérieur',
        ][$this->type] ?? $this->type;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helpers
    public static function getStatut()
    {
        return static::where('type', 'statut')
            ->active()
            ->latest()
            ->first();
    }

    public static function getReglementInterieur()
    {
        return static::where('type', 'reglement-interieur')
            ->active()
            ->latest()
            ->first();
    }
}
