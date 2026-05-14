<?php

namespace App\Models\Wedding\Gallery;

use Illuminate\Database\Eloquent\Model;

class WeddingGallerySection2 extends Model
{
    protected $table = 'wedding_gallery_section2';

    /**
     * Disable automatic timestamps if your migration does not include
     * created_at / updated_at columns. If your table DOES have those
     * columns you can remove this line.
     */
    public $timestamps = false;

    protected $fillable = [
        'images'
    ];

    protected $casts = [
        'images' => 'array'
    ];
}