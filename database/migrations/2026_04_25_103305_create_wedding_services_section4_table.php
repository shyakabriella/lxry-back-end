<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingServicesSection4Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_services_section4', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Culinary Enhancements');
            
            // Card 1 fields
            $table->string('card1_title')->nullable();
            $table->text('card1_description')->nullable();
            
            // Card 2 fields
            $table->string('card2_title')->nullable();
            $table->text('card2_description')->nullable();
            
            // Card 3 fields
            $table->string('card3_title')->nullable();
            $table->text('card3_description')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_services_section4');
    }
}