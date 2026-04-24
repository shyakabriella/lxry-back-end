<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section9RestaurantBar extends Model
{
    protected $table = 'section9_restaurant_bar';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}