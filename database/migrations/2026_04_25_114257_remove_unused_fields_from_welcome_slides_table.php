<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('welcome_slides', function (Blueprint $table) {
            if (Schema::hasColumn('welcome_slides', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('welcome_slides', 'button_text')) {
                $table->dropColumn('button_text');
            }

            if (Schema::hasColumn('welcome_slides', 'button_link')) {
                $table->dropColumn('button_link');
            }
        });

        Schema::table('welcome_slides', function (Blueprint $table) {
            if (Schema::hasColumn('welcome_slides', 'subtitle')) {
                $table->string('subtitle')->nullable()->change();
            }

            if (Schema::hasColumn('welcome_slides', 'sort_order')) {
                $table->integer('sort_order')->default(0)->change();
            }

            if (Schema::hasColumn('welcome_slides', 'is_active')) {
                $table->boolean('is_active')->default(true)->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('welcome_slides', function (Blueprint $table) {
            if (!Schema::hasColumn('welcome_slides', 'description')) {
                $table->text('description')->nullable()->after('subtitle');
            }

            if (!Schema::hasColumn('welcome_slides', 'button_text')) {
                $table->string('button_text')->nullable()->after('description');
            }

            if (!Schema::hasColumn('welcome_slides', 'button_link')) {
                $table->string('button_link')->nullable()->after('button_text');
            }
        });
    }
};