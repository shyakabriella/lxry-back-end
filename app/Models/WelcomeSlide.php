<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WelcomeSlide extends Model
{
    protected $table = 'wedding_slides';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url',
        'sort_order'
    ];
}