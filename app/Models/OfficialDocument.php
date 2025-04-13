<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class OfficialDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'document_type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'issue_date',
        'expiry_date',
        'is_public',
        'is_active',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
} 