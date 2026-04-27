<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderAndIsActiveToSection9RestaurantBarTable extends Migration
{
    public function up()
    {
        Schema::table('section9_restaurant_bar', function (Blueprint $table) {
            if (!Schema::hasColumn('section9_restaurant_bar', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('image_url');
            }

            if (!Schema::hasColumn('section9_restaurant_bar', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
        });
    }

    public function down()
    {
        Schema::table('section9_restaurant_bar', function (Blueprint $table) {
            if (Schema::hasColumn('section9_restaurant_bar', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('section9_restaurant_bar', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
}