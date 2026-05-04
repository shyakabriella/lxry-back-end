<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wedding_room_blocks_section2', function (Blueprint $table) {
            $table->json('images')->nullable()->after('image_url');
        });
    }

    public function down()
    {
        Schema::table('wedding_room_blocks_section2', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};