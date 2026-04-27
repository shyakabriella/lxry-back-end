<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingGallerySection2Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_gallery_section2', function (Blueprint $table) {
            $table->id();
            $table->json('images'); // Store 30 images as JSON array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_gallery_section2');
    }
}