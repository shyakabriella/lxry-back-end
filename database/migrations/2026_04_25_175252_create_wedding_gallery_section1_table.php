<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingGallerySection1Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_gallery_section1', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Overview');
            $table->string('subtitle')->default('Luxury Living Moments');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_gallery_section1');
    }
}