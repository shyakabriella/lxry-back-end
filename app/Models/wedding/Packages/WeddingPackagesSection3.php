<?php

namespace App\Models\Wedding\Packages;

use Illuminate\Database\Eloquent\Model;

class WeddingPackagesSection3 extends Model
{
    protected $table = 'wedding_packages_section3';
    
    protected $fillable = [
        'title',
        'image_url',
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
}