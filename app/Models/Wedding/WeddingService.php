<?php

namespace App\Models\Wedding;

use Illuminate\Database\Eloquent\Model;

class WeddingService extends Model
{
    protected $table = 'wedding_services';
    
    protected $fillable = [
        'service_name'
    ];
}