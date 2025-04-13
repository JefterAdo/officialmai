<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'position',
        'image',
        'biography',
        'email',
        'phone',
        'social_media',
        'order',
        'is_active',
        'organization_structure_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'social_media' => 'array'
    ];

    public function structure()
    {
        return $this->belongsTo(OrganizationStructure::class, 'organization_structure_id');
    }
}
