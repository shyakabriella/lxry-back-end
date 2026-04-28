<?php

namespace App\Models\Wedding\Packages;

use Illuminate\Database\Eloquent\Model;

class WeddingPackagesSection1 extends Model
{
    protected $table = 'wedding_packages_section1';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description'
    ];
}