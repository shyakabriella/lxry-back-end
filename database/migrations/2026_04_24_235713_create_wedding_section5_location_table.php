<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingSection5LocationTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_section5_location', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Location');
            $table->string('subtitle')->default('Our venues');
            $table->text('description');
            $table->string('image_url');
            $table->json('features')->nullable(); // Array of venue features
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_section5_location');
    }
}