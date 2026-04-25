<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingSection3ApartmentTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_section3_apartment', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Prime Luxury Apartment Living');
            $table->string('subtitle')->default('Discover Modern Apartments Designed For Comfort, Elegance And Everyday Living');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->json('amenities')->nullable(); // Array of amenities
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_section3_apartment');
    }
}