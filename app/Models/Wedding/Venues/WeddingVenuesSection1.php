<?php

namespace App\Models\Wedding\Venues;

use Illuminate\Database\Eloquent\Model;

class WeddingVenuesSection1 extends Model
{
    protected $table = 'wedding_venues_section1';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description'
    ];
}