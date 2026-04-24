<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section10Sauna extends Model
{
    protected $table = 'section10_sauna';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'images'
    ];
    
    protected $casts = [
        'images' => 'array' // Automatically cast JSON to array
    ];
}