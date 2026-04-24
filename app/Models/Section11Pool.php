<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section11Pool extends Model
{
    protected $table = 'section11_pool';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}