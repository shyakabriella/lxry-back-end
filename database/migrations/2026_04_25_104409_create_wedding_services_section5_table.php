<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeddingServicesSection5Table extends Migration
{
    public function up()
    {
        Schema::create('wedding_services_section5', function (Blueprint $table) {
            $table->id();
            $table->json('items'); // Store array of items (up to 12 items)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wedding_services_section5');
    }
}