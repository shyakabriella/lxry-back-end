<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section8Parking extends Model
{
    protected $table = 'section8_parking';

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