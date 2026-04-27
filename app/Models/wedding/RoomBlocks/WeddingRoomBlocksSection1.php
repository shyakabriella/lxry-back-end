<?php

namespace App\Models\Wedding\RoomBlocks;

use Illuminate\Database\Eloquent\Model;

class WeddingRoomBlocksSection1 extends Model
{
    protected $table = 'wedding_room_blocks_section1';
    
    protected $fillable = [
        'title',
        'subtitle',
        'description'
    ];
}