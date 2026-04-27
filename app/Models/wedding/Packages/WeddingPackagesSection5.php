<?php

namespace App\Models\Wedding\Packages;

use Illuminate\Database\Eloquent\Model;

class WeddingPackagesSection5 extends Model
{
    protected $table = 'wedding_packages_section5';
    
    protected $fillable = [
        'title',
        'subtitle',
        'block1_title',
        'block1_image',
        'block1_item1',
        'block1_item2',
        'block1_item3',
        'block1_item4',
        'block2_title',
        'block2_image',
        'block2_item1',
        'block2_item2',
        'block2_item3',
        'block2_item4',
        'block3_title',
        'block3_image',
        'block3_item1',
        'block3_item2',
        'block3_item3',
        'block3_item4',
        'block4_title',
        'block4_image',
        'block4_item1',
        'block4_item2',
        'block4_item3',
        'block4_item4'
    ];
}