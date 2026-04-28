<?php

namespace App\Models\Wedding\Venues;

use Illuminate\Database\Eloquent\Model;

class WeddingVenuesSection2 extends Model
{
    protected $table = 'wedding_venues_section2';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}