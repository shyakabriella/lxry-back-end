<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingVenuesHeroTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_venues_hero', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('background_image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_venues_hero');
    }
}