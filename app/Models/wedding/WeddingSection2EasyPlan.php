<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingSection2EasyPlan extends Model
{
    protected $table = 'wedding_section2_easy_plan';
    
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'features'
    ];
    
    protected $casts = [
        'features' => 'array'
    ];
}