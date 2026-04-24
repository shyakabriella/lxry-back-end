<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection5LuxuryTable extends Migration
{
    public function up()
    {
        Schema::create('section5_luxury', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Luxury');
            $table->string('subtitle')->default('The Lay Of The Land');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section5_luxury');
    }
}