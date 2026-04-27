<?php

namespace App\Models\Wedding\Services;

use Illuminate\Database\Eloquent\Model;

class WeddingServicesSection4 extends Model
{
    protected $table = 'wedding_services_section4';
    
    protected $fillable = [
        'title',
        'card1_title',
        'card1_description',
        'card2_title',
        'card2_description',
        'card3_title',
        'card3_description'
    ];
}