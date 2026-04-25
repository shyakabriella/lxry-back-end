<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSection5Location extends Model
{
    protected $table = 'wedding_section5_location';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url',
        'features'
    ];
    
    protected $casts = [
        'features' => 'array'
    ];
}