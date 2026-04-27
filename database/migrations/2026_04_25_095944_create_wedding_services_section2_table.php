<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingServicesSection2Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_services_section2', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Seamless Wedding Experience');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }   

    public function down()
    {
        Schema::dropIfExists('wedding_services_section2');
    }
}