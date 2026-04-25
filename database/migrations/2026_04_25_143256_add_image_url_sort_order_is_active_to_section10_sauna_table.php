<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageUrlSortOrderIsActiveToSection10SaunaTable extends Migration
{
    public function up()
    {
        Schema::table('section10_sauna', function (Blueprint $table) {
            if (!Schema::hasColumn('section10_sauna', 'image_url')) {
                $table->string('image_url')->nullable()->after('description');
            }

            if (!Schema::hasColumn('section10_sauna', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('image_url');
            }

            if (!Schema::hasColumn('section10_sauna', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
        });
    }

    public function down()
    {
        Schema::table('section10_sauna', function (Blueprint $table) {
            if (Schema::hasColumn('section10_sauna', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('section10_sauna', 'sort_order')) {
                $table->dropColumn('sort_order');
            }

            if (Schema::hasColumn('section10_sauna', 'image_url')) {
                $table->dropColumn('image_url');
            }
        });
    }
}