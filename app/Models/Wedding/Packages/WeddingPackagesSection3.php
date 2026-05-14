<?php

namespace App\Models\Wedding\Packages;

use Illuminate\Database\Eloquent\Model;

class WeddingPackagesSection3 extends Model
{
    protected $table = 'wedding_packages_section3';
    
    protected $fillable = [
        'title',
        'image_url',
        'items',  // Add this for JSON storage
        'feature1',
        'feature2',
        'feature3',
        'feature4',
        'feature5',
        'feature6',
        'feature7',
        'feature8',
        'feature9',
        'feature10'
    ];
    
    protected $casts = [
        'items' => 'array'  // Cast items to array automatically
    ];
}