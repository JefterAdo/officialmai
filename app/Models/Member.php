<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'birth_date',
        'profession',
        'section_id',
        'membership_number',
        'membership_date',
        'membership_type',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'membership_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
} 