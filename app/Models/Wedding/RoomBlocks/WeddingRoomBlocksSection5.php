<?php

namespace App\Models\Wedding\RoomBlocks;

use Illuminate\Database\Eloquent\Model;

class WeddingRoomBlocksSection5 extends Model
{
    protected $table = 'wedding_room_blocks_section5';
    
    protected $fillable = [
        'title',
        'amenities'
    ];
    
    protected $casts = [
        'amenities' => 'array'
    ];
}