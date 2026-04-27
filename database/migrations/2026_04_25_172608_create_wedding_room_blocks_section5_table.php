<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingRoomBlocksSection5Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_room_blocks_section5', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Restful Essentials');
            $table->json('amenities'); // Store amenities as JSON array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_room_blocks_section5');
    }
}