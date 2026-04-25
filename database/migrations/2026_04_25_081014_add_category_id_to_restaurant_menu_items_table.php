<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurant_menu_items', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurant_menu_items', 'category_id')) {
                $table->foreignId('category_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('restaurant_menu_categories')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('restaurant_menu_items', 'tab')) {
                $table->enum('tab', ['restaurant', 'bar'])
                    ->default('restaurant')
                    ->after('category_id');
            }

            if (!Schema::hasColumn('restaurant_menu_items', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('restaurant_menu_items', function (Blueprint $table) {
            if (Schema::hasColumn('restaurant_menu_items', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }

            if (Schema::hasColumn('restaurant_menu_items', 'tab')) {
                $table->dropColumn('tab');
            }

            if (Schema::hasColumn('restaurant_menu_items', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
    }
};