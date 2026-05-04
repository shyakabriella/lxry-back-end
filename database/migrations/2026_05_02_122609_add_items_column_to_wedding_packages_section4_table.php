<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wedding_packages_section4', function (Blueprint $table) {
            if (!Schema::hasColumn('wedding_packages_section4', 'items')) {
                $table->json('items')->nullable()->after('title');
            }
        });
    }

    public function down()
    {
        Schema::table('wedding_packages_section4', function (Blueprint $table) {
            if (Schema::hasColumn('wedding_packages_section4', 'items')) {
                $table->dropColumn('items');
            }
        });
    }
};