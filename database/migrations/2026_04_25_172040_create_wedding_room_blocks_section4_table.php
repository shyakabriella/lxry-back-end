<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingRoomBlocksSection4Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_room_blocks_section4', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Penthouses');
            $table->string('subtitle')->default('Sleeps 6-20');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_room_blocks_section4');
    }
}