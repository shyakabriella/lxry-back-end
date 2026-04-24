<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MassageSpaBenefit extends Model
{
    protected $fillable = [
        'title',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}