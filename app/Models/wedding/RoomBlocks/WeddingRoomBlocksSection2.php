<?php

namespace App\Models\Wedding\RoomBlocks;

use Illuminate\Database\Eloquent\Model;

class WeddingRoomBlocksSection2 extends Model
{
    protected $table = 'wedding_room_blocks_section2';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_url'
    ];
}