<?php

namespace App\Models\Wedding\Services;

use Illuminate\Database\Eloquent\Model;

class WeddingServicesSection1 extends Model
{
    protected $table = 'wedding_services_section1';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description'
    ];
}