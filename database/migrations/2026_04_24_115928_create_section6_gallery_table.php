<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection6GalleryTable extends Migration
{
    public function up()
    {
        Schema::create('section6_gallery', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section6_gallery');
    }
}