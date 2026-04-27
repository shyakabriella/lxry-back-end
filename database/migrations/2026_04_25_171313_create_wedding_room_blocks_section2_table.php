<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingRoomBlocksSection2Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_room_blocks_section2', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Guest Rooms');
            $table->string('subtitle')->default('1 or 2 King | Sleeps 2-6');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_room_blocks_section2');
    }
}