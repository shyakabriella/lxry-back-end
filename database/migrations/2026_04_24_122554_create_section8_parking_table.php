<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection8ParkingTable extends Migration
{
    public function up()
    {
        Schema::create('section8_parking', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Parking Facilities');
            $table->string('subtitle')->default('Safe Space For Your Journey');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section8_parking');
    }
}