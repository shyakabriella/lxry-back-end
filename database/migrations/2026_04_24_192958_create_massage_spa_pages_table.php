<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('massage_spa_pages', function (Blueprint $table) {
            $table->id();

            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();

            $table->string('intro_eyebrow')->nullable();
            $table->string('intro_title')->nullable();
            $table->text('intro_description')->nullable();

            $table->string('experience_title')->nullable();
            $table->text('experience_description')->nullable();
            $table->string('experience_image')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('massage_spa_pages');
    }
};