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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // --- PERBAIKAN DI SINI ---
            // 1. User: Jika user dihapus, tulisan ikut terhapus (Cascade)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // 2. Category: Tambahkan ->nullable() agar nullOnDelete bekerja
            // Artinya: Jika kategori dihapus, tulisan tetap ada tapi tanpa kategori.
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // 3. Status: Ini juga harus nullable
            $table->foreignId('status_id')->nullable()->constrained()->nullOnDelete();

            // Data Tulisan
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('thumbnail')->nullable();

            // Meta Data
            $table->dateTime('published_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views')->default(0);

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tulisan');
    }
};
