<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingRoomBlocksSection3Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_room_blocks_section3', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Cottages');
            $table->string('subtitle')->default('1 King | Sleeps 2');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_room_blocks_section3');
    }
}