<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_page_section_two', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Section Two Title');
            $table->string('sub_title')->default('Section Two Sub Title');

            // TEXT column cannot have default value in MySQL
            $table->text('description');

            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // Insert default first data here instead of using default() on TEXT column
        DB::table('home_page_section_two')->insert([
            'title' => 'Section Two Title',
            'sub_title' => 'Section Two Sub Title',
            'description' => 'Section Two Description',
            'image_url' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_page_section_two');
    }
};