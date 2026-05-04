<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wedding_room_blocks_section2', function (Blueprint $table) {
            // Make columns nullable
            if (Schema::hasColumn('wedding_room_blocks_section2', 'title')) {
                $table->string('title')->nullable()->change();
            }
            if (Schema::hasColumn('wedding_room_blocks_section2', 'subtitle')) {
                $table->string('subtitle')->nullable()->change();
            }
            if (Schema::hasColumn('wedding_room_blocks_section2', 'description')) {
                $table->text('description')->nullable()->change();
            }
            if (Schema::hasColumn('wedding_room_blocks_section2', 'image_url')) {
                $table->string('image_url')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('wedding_room_blocks_section2', function (Blueprint $table) {
            if (Schema::hasColumn('wedding_room_blocks_section2', 'title')) {
                $table->string('title')->nullable(false)->change();
            }
            if (Schema::hasColumn('wedding_room_blocks_section2', 'subtitle')) {
                $table->string('subtitle')->nullable(false)->change();
            }
            if (Schema::hasColumn('wedding_room_blocks_section2', 'description')) {
                $table->text('description')->nullable(false)->change();
            }
            if (Schema::hasColumn('wedding_room_blocks_section2', 'image_url')) {
                $table->string('image_url')->nullable(false)->change();
            }
        });
    }
};