<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section8Parking extends Model
{
    protected $table = 'section8_parking';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}