<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSortOrderAndIsActiveToSection12FamilyKidsTable extends Migration
{
    public function up()
    {
        Schema::table('section12_family_kids', function (Blueprint $table) {
            if (!Schema::hasColumn('section12_family_kids', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('image_url');
            }

            if (!Schema::hasColumn('section12_family_kids', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
        });
    }

    public function down()
    {
        Schema::table('section12_family_kids', function (Blueprint $table) {
            if (Schema::hasColumn('section12_family_kids', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('section12_family_kids', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
}