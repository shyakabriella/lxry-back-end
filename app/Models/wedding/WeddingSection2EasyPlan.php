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
        'features',
        'display_order',
        'is_active'
    ];
    
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'display_order' => 'integer'
    ];
}