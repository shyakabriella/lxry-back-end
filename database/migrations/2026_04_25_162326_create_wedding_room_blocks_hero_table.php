<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingRoomBlocksHeroTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_room_blocks_hero', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Room Blocks');
            $table->string('background_image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_room_blocks_hero');
    }
}