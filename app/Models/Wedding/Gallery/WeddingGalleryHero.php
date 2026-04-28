<?php

namespace App\Models\Wedding\Gallery;

use Illuminate\Database\Eloquent\Model;

class WeddingGalleryHero extends Model
{
    protected $table = 'wedding_gallery_hero';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'background_image'
    ];
}