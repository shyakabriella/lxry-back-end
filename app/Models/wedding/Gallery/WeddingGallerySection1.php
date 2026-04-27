<?php

namespace App\Models\Wedding\Gallery;

use Illuminate\Database\Eloquent\Model;

class WeddingGallerySection1 extends Model
{
    protected $table = 'wedding_gallery_section1';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description'
    ];
}