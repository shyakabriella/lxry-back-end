<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section10Sauna extends Model
{
    protected $table = 'section10_sauna';

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