<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingServicesSection3Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_services_section3', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Catering');
            
            // Card 1 fields
            $table->string('card1_title')->nullable();
            $table->string('card1_subtitle')->nullable();
            $table->text('card1_description')->nullable();
            $table->string('card1_image')->nullable();
            
            // Card 2 fields
            $table->string('card2_title')->nullable();
            $table->string('card2_subtitle')->nullable();
            $table->text('card2_description')->nullable();
            $table->string('card2_image')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_services_section3');
    }
}