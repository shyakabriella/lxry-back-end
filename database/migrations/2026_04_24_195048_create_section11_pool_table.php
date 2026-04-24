<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection11PoolTable extends Migration
{
    public function up()
    {
        Schema::create('section11_pool', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Infinity Pool Experience');
            $table->string('subtitle')->default('Relax. Refresh. Repeat.');
            $table->text('description');
            $table->string('image_url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section11_pool');
    }
}