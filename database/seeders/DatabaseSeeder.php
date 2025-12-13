<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin (Jika belum ada)
        $user = User::firstOrCreate(
            ['email' => 'admin@mesuluh.com'],
            [
                'name' => 'Admin Mesuluh',
                'password' => bcrypt('password'), // Password standar
                'email_verified_at' => now(),
            ]
        );

        // 2. Buat Status (Penting untuk filter Published)
        $statusPublished = Status::firstOrCreate(['name' => 'Published'], ['slug' => 'published', 'color' => 'success']);
        $statusDraft = Status::firstOrCreate(['name' => 'Draft'], ['slug' => 'draft', 'color' => 'warning']);

        // 3. Buat Kategori (Sesuai Menu)
        $categories = [
            ['name' => 'Sulur', 'description' => 'Menelusuri akar kisah yang mendalam.'],
            ['name' => 'Suluh', 'description' => 'Menjadi penerang dan inspirasi.'],
            ['name' => 'Singgah', 'description' => 'Tempat istirahat sejenak menikmati cerita ringan.'],
            ['name' => 'Taut', 'description' => 'Menautkan rasa dan solidaritas bersama.'],
        ];

        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'text_color' => '#8b004b', // Magenta Mesuluh
                    'bg_color' => '#fff8e8',   // Krem Mesuluh
                ]
            );

            // 4. ISI POSTINGAN UNTUK SETIAP KATEGORI
            // Kita buat 8 postingan per kategori (Total 32 Post)
            for ($i = 1; $i <= 8; $i++) {
                
                $title = fake()->sentence(6); // Judul acak
                
                Post::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'status_id' => $statusPublished->id, // Pastikan Published
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . Str::random(5),
                    'excerpt' => fake()->paragraph(3), // Ringkasan
                    'content' => $this->generateContent(), // Isi konten panjang
                    'thumbnail' => 'posts/thumbnails/default.jpg', // Gambar dummy tadi
                    'published_at' => fake()->dateTimeBetween('-1 year', 'now'), // Tanggal acak setahun terakhir
                    'is_featured' => fake()->boolean(20), // 20% kemungkinan jadi Featured/Headline
                    'views' => fake()->numberBetween(100, 5000), // Jumlah view acak biar seru
                ]);
            }
        }
        
        // Buat 1 Postingan Spesifik untuk Headline (Pasti Featured)
        Post::create([
            'user_id' => $user->id,
            'category_id' => Category::where('slug', 'suluh')->first()->id,
            'status_id' => $statusPublished->id,
            'title' => 'Pariwisata Bali yang Auto Pilot atau Kinerja Pemerintahnya yang Semakin Merosot?!',
            'slug' => 'pariwisata-bali-auto-pilot',
            'excerpt' => 'Ternyata tidak cukup hanya dengan viralitas semata demi bisa menyadarkan para pejabat legislatif maupun eksekutif di Bali.',
            'content' => $this->generateContent(),
            'thumbnail' => 'posts/thumbnails/default.jpg',
            'published_at' => now(),
            'is_featured' => true,
            'views' => 9999,
        ]);
    }

    // Fungsi helper untuk bikin konten HTML panjang
    private function generateContent()
    {
        $content = '';
        // Bikin 4 paragraf
        for ($j = 0; $j < 4; $j++) {
            $content .= '<p>' . fake()->paragraph(5) . '</p>';
            if ($j == 1) {
                $content .= '<h3>' . fake()->sentence(4) . '</h3>'; // Sisipkan Sub-judul
            }
        }
        return $content;
    }
}