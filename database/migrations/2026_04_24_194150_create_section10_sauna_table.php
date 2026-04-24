<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSection10SaunaTable extends Migration
{
    public function up()
    {
        Schema::create('section10_sauna', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Sauna & Massage Experience');
            $table->string('subtitle')->default('Relax. Restore. Rebalance.');
            $table->text('description');
            $table->json('images')->nullable(); // Store multiple images as JSON array
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('section10_sauna');
    }
}