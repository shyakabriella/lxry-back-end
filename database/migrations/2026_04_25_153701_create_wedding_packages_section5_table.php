<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingPackagesSection5Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_packages_section5', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Bar Packages');
            $table->string('subtitle')->nullable();
            
            // Block 1 (SIMPLE)
            $table->string('block1_title')->nullable();
            $table->string('block1_image')->nullable();
            $table->string('block1_item1')->nullable();
            $table->string('block1_item2')->nullable();
            $table->string('block1_item3')->nullable();
            $table->string('block1_item4')->nullable();
            
            // Block 2 (TOP SHELF)
            $table->string('block2_title')->nullable();
            $table->string('block2_image')->nullable();
            $table->string('block2_item1')->nullable();
            $table->string('block2_item2')->nullable();
            $table->string('block2_item3')->nullable();
            $table->string('block2_item4')->nullable();
            
            // Block 3 (HOUSE)
            $table->string('block3_title')->nullable();
            $table->string('block3_image')->nullable();
            $table->string('block3_item1')->nullable();
            $table->string('block3_item2')->nullable();
            $table->string('block3_item3')->nullable();
            $table->string('block3_item4')->nullable();
            
            // Block 4 (CALL)
            $table->string('block4_title')->nullable();
            $table->string('block4_image')->nullable();
            $table->string('block4_item1')->nullable();
            $table->string('block4_item2')->nullable();
            $table->string('block4_item3')->nullable();
            $table->string('block4_item4')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_packages_section5');
    }
}