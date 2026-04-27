<?php

namespace App\Models\Wedding\RoomBlocks;

use Illuminate\Database\Eloquent\Model;

class WeddingRoomBlocksHero extends Model
{
    protected $table = 'wedding_room_blocks_hero';
    
    protected $fillable = [
        'title',
        'background_image'
    ];
}