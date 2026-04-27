<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section12FamilyKids extends Model
{
    protected $table = 'section12_family_kids';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}