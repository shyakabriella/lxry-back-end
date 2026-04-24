<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection9RestaurantBarTable extends Migration
{
    public function up()
    {
        Schema::create('section9_restaurant_bar', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Restaurant & Bar Experience');
            $table->string('subtitle')->default('Taste. Sip. Enjoy.');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section9_restaurant_bar');
    }
}