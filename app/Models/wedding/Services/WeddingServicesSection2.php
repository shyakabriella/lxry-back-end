<?php

namespace App\Models\Wedding\Services;

use Illuminate\Database\Eloquent\Model;

class WeddingServicesSection2 extends Model
{
    protected $table = 'wedding_services_section2';
    
    protected $fillable = [
        'title',
        'description',
        'image_url'
    ];
}