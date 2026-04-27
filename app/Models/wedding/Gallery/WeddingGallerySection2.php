<?php

namespace App\Models\Wedding\Gallery;

use Illuminate\Database\Eloquent\Model;

class WeddingGallerySection2 extends Model
{
    protected $table = 'wedding_gallery_section2';
    
    protected $fillable = [
        'images'
    ];
    
    protected $casts = [
        'images' => 'array'
    ];
}