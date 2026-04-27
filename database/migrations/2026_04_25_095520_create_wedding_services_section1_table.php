<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingServicesSection1Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_services_section1', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Luxury Wedding Venues in Kigali, Rwanda');
            $table->string('subtitle')->default('Full-Service Wedding Planning');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_services_section1');
    }
}