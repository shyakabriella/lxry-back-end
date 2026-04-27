<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingPackagesSection4Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_packages_section4', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Nullable title
            
            // Benefits as separate columns
            $table->string('benefit1')->nullable();
            $table->string('benefit2')->nullable();
            $table->string('benefit3')->nullable();
            $table->string('benefit4')->nullable();
            $table->string('benefit5')->nullable();
            $table->string('benefit6')->nullable();
            $table->string('benefit7')->nullable();
            $table->string('benefit8')->nullable();
            $table->string('benefit9')->nullable();
            $table->string('benefit10')->nullable();
            $table->string('benefit11')->nullable();
            $table->string('benefit12')->nullable();
            $table->string('benefit13')->nullable();
            $table->string('benefit14')->nullable();
            $table->string('benefit15')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_packages_section4');
    }
}