<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingPackagesSection2Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_packages_section2', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Classic Package');
            $table->string('image_url')->nullable();
            
            // Features as separate columns for easy editing
            $table->string('feature1')->nullable();
            $table->string('feature2')->nullable();
            $table->string('feature3')->nullable();
            $table->string('feature4')->nullable();
            $table->string('feature5')->nullable();
            $table->string('feature6')->nullable();
            $table->string('feature7')->nullable();
            $table->string('feature8')->nullable();
            $table->string('feature9')->nullable();
            $table->string('feature10')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_packages_section2');
    }
}