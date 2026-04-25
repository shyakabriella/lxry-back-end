<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingSection2EasyPlanTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_section2_easy_plan', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Easy to Plan');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->json('features')->nullable(); // Array of features
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_section2_easy_plan');
    }
}