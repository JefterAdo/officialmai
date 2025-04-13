<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlashInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'is_active',
        'start_date',
        'end_date',
        'display_order',
        'display_mode'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public const DISPLAY_MODES = [
        'static' => 'Statique',
        'scroll' => 'Défilement',
        'fade' => 'Fondu'
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('display_order');
    }
}
