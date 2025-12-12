<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Sulur, Suluh, Singgah, Taut
            $table->string('slug')->unique();
            $table->string('text_color')->nullable(); // Untuk warna tulisan label
            $table->string('bg_color')->nullable();   // Untuk warna latar label
            $table->text('description')->nullable();  // SEO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
