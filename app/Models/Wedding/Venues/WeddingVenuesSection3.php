<?php

namespace App\Models\Wedding\Venues;

use Illuminate\Database\Eloquent\Model;

class WeddingVenuesSection3 extends Model
{
    protected $table = 'wedding_venues_section3';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}