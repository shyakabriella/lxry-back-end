<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSection3Apartment extends Model
{
    protected $table = 'wedding_section3_apartment';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url',
        'amenities'
    ];
    
    protected $casts = [
        'amenities' => 'array'
    ];
}