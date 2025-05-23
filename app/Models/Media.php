<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'description',
        'alt_text',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
} 