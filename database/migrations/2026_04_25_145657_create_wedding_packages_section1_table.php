<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingPackagesSection1Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_packages_section1', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Wedding Packages');
            $table->string('subtitle')->default('Simple Luxury Options');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_packages_section1');
    }
}