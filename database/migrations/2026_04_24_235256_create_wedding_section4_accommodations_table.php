<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingSection4AccommodationsTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_section4_accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Wedding Accommodations');
            $table->string('subtitle')->default('Luxury Guest Suites');
            $table->text('description');
            $table->string('image_url');
            $table->json('amenities')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_section4_accommodations');
    }
}   