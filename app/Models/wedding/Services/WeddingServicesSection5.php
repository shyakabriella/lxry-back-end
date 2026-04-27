<?php

namespace App\Models\Wedding\Services;

use Illuminate\Database\Eloquent\Model;

class WeddingServicesSection5 extends Model
{
    protected $table = 'wedding_services_section5';
    
    protected $fillable = [
        'items'
    ];
    
    protected $casts = [
        'items' => 'array'
    ];
}