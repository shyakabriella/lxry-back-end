<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection7FitnessTable extends Migration
{
    public function up()
    {
        Schema::create('section7_fitness', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Fitness Center & Wellness Zone');
            $table->string('subtitle')->default('Train Hard Stay Strong');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section7_fitness');
    }
}