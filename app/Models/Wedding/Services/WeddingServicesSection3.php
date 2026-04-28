<?php

namespace App\Models\Wedding\Services;

use Illuminate\Database\Eloquent\Model;

class WeddingServicesSection3 extends Model
{
    protected $table = 'wedding_services_section3';
    
    protected $fillable = [
        'title',
        'card1_title',
        'card1_subtitle',
        'card1_description',
        'card1_image',
        'card2_title',
        'card2_subtitle',
        'card2_description',
        'card2_image'
    ];
}