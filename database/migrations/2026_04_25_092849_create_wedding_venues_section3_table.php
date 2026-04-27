<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingVenuesSection3Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_venues_section3', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Wedding Reception Hall');
            $table->string('subtitle')->default('INDOOR VENUE | UP TO 400 GUESTS');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_venues_section3');
    }
}