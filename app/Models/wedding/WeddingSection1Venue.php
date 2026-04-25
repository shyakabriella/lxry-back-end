<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSection1Venue extends Model
{
    protected $table = 'wedding_section1_venues';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'images'
    ];
    
    protected $casts = [
        'images' => 'array'
    ];
}