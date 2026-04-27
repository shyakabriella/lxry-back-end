<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingServicesTable extends Migration
{
    public function up()
    {
        Schema::create('wedding_services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_services');
    }
}