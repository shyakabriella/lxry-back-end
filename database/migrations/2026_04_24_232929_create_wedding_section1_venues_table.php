<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingSection1VenuesTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_section1_venues', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Wedding Venues Luxury');
            $table->string('subtitle')->default('Envision Your Special Day');
            $table->text('description');
            $table->json('images'); // Store multiple images as JSON array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_section1_venues');
    }
}