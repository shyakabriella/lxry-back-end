<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();

            $table->string('customer_name');
            $table->string('phone');
            $table->string('email')->nullable();

            $table->enum('booking_type', ['table', 'buy_now'])->default('table');
            $table->enum('payment_method', ['counter', 'room', 'card'])->default('counter');

            $table->date('booking_date')->nullable();
            $table->time('booking_time')->nullable();
            $table->unsignedInteger('party_size')->nullable();

            $table->text('custom_dish')->nullable();
            $table->text('notes')->nullable();

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_bookings');
    }
};