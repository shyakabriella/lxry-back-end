<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDisplayOrderToWeddingSection2EasyPlanTable extends Migration
{
    public function up()
    {
        Schema::table('wedding_section2_easy_plan', function (Blueprint $table) {
            $table->integer('display_order')->default(0)->after('features');
            $table->boolean('is_active')->default(true)->after('display_order');
        });
    }

    public function down()
    {
        Schema::table('wedding_section2_easy_plan', function (Blueprint $table) {
            $table->dropColumn('display_order');
            $table->dropColumn('is_active');
        });
    }
}