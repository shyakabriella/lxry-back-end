<?php

namespace App\Models\Wedding\Services;

use Illuminate\Database\Eloquent\Model;

class WeddingServicesHero extends Model
{
    protected $table = 'wedding_services_hero';
    
    protected $fillable = [
        'title',
        'background_image'
    ];
}