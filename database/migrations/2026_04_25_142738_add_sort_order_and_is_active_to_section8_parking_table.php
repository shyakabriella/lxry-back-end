<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderAndIsActiveToSection8ParkingTable extends Migration
{
    public function up()
    {
        Schema::table('section8_parking', function (Blueprint $table) {
            if (!Schema::hasColumn('section8_parking', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('image_url');
            }

            if (!Schema::hasColumn('section8_parking', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
        });
    }

    public function down()
    {
        Schema::table('section8_parking', function (Blueprint $table) {
            if (Schema::hasColumn('section8_parking', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('section8_parking', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
}