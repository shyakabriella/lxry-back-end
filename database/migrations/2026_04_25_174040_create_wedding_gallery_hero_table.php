<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingGalleryHeroTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_gallery_hero', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Luxury Apartments');
            $table->string('subtitle')->default('Gallery');
            $table->text('description')->nullable();
            $table->string('background_image');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_gallery_hero');
    }
}