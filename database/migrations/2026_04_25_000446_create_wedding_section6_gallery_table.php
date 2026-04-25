<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingSection6GalleryTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_section6_gallery', function (Blueprint $table) {
            $table->id();
            $table->json('images'); // Store 5 images as JSON array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_section6_gallery');
    }
}