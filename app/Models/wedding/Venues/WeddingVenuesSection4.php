<?php

namespace App\Models\Wedding\Venues;

use Illuminate\Database\Eloquent\Model;

class WeddingVenuesSection4 extends Model
{
    protected $table = 'wedding_venues_section4';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}