<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingVenuesSection4Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_venues_section4', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Bar & Lounge');
            $table->string('subtitle')->default('PREMIUM LOUNGE | UP TO 150 GUESTS');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_venues_section4');
    }
}