<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingVenuesSection2Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_venues_section2', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Garden Ceremony Venue');
            $table->string('subtitle')->default('OUTDOOR VENUE | UP TO 500 GUESTS');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_venues_section2');
    }
}