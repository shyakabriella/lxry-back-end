<?php

namespace App\Models\Wedding\Packages;

use Illuminate\Database\Eloquent\Model;

class WeddingPackagesHero extends Model
{
    protected $table = 'wedding_packages_hero';
    
    protected $fillable = [
        'title',
        'background_image'
    ];
}