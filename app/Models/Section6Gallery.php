<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section6Gallery extends Model
{
    protected $table = 'section6_gallery';
    
    protected $fillable = [
        'image_url',
        'display_order',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer'
    ];
}