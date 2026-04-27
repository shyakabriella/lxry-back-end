<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingServicesHeroTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_services_hero', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Wedding Services');
            $table->string('background_image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_services_hero');
    }
}