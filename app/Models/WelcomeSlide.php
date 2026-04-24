<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeSlide extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_url'
    ];
}