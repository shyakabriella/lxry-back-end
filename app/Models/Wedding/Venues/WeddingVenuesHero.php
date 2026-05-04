<?php

namespace App\Models\Wedding\Venues;

use Illuminate\Database\Eloquent\Model;

class WeddingVenuesHero extends Model
{
    protected $table = 'wedding_venues_hero';
    
    protected $fillable = [
        'title',
        'background_image'
    ];
}