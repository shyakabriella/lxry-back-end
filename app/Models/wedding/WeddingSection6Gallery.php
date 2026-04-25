<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSection6Gallery extends Model
{
    protected $table = 'wedding_section6_gallery';
    
    protected $fillable = [
        'images'
    ];
    
    protected $casts = [
        'images' => 'array'
    ];
}