<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection12FamilyKidsTable extends Migration
{
    public function up()
    {
        Schema::create('section12_family_kids', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Family Experience & Kids Zone');
            $table->string('subtitle')->default('Where Joy Comes Alive');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section12_family_kids');
    }
}