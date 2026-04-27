<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingRoomBlocksSection1Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_room_blocks_section1', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Meeting Rooms in California');
            $table->string('subtitle')->default('Room for Everyone');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_room_blocks_section1');
    }
}