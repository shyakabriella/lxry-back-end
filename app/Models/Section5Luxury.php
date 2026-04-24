<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section5Luxury extends Model
{
    protected $table = 'section5_luxury';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}
