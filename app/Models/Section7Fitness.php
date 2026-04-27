<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section7Fitness extends Model
{
    protected $table = 'section7_fitness';

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