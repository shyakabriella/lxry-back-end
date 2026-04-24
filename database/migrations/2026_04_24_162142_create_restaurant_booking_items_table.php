<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_booking_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('restaurant_booking_id')
                ->constrained('restaurant_bookings')
                ->cascadeOnDelete();

            $table->foreignId('restaurant_menu_item_id')
                ->nullable()
                ->constrained('restaurant_menu_items')
                ->nullOnDelete();

            $table->string('item_name');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_booking_items');
    }
};