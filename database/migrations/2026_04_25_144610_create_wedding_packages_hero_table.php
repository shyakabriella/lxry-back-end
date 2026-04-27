<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingPackagesHeroTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_packages_hero', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Packages');
            $table->string('background_image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_packages_hero');
    }
}