<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSection4Accommodation extends Model
{
    protected $table = 'wedding_section4_accommodations';
    
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