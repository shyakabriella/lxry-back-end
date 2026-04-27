<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingVenuesSection1Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_venues_section1', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Luxury Wedding Venues in Kigali, Rwanda');
            $table->string('subtitle')->default('Elegant Celebration Spaces');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_venues_section1');
    }
}