<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Quote;
use App\Models\Status;
use App\Models\Category;
use App\Models\TeamMember;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Sedang mengisi data ke database Mesuluh...');
        // 1. BUAT ROLES
        // $adminRole = Role::firstOrCreate(['id' => 1], ['name' => 'Admin'], ['slug' => 'admin']);
        // $editorRole = Role::firstOrCreate(['id' => 2], ['name' => 'Editor'], ['slug' => 'editor']);
        // $penulisRole = Role::firstOrCreate(['id' => 3], ['name' => 'Penulis'], ['slug' => 'penulis']);

        // 1. BUAT ROLES (Gabungkan data yang ingin disimpan ke array kedua)
        $adminRole = Role::firstOrCreate(['id' => 1], ['name' => 'Admin', 'slug' => 'admin']);
        $editorRole = Role::firstOrCreate(['id' => 2], ['name' => 'Editor', 'slug' => 'editor']);
        $penulisRole = Role::firstOrCreate(['id' => 3], ['name' => 'Penulis', 'slug' => 'penulis']);
        $this->command->info('Roles berhasil dibuat.');

        // 2. BUAT STATUSES (URUTAN PENTING!)
        Status::firstOrCreate(['id' => 1], ['name' => 'Draft', 'color' => 'gray']);
        Status::firstOrCreate(['id' => 2], ['name' => 'Review', 'color' => 'warning']);
        Status::firstOrCreate(['id' => 3], ['name' => 'Published', 'color' => 'success']);
        Status::firstOrCreate(['id' => 4], ['name' => 'Revisi', 'color' => 'danger']);
        Status::firstOrCreate(['id' => 5], ['name' => 'Ditolak', 'color' => 'danger']);
        $this->command->info('Statuses berhasil dibuat.');

        // 3. BUAT USER ADMIN UTAMA
        $user = User::firstOrCreate(
            ['email' => 'admin@mesuluh.com'],
            [
                'name' => 'Admin Mesuluh',
                'username' => 'admin-mesuluh',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('User berhasil dibuat.');

        // 4. Buat Status (Penting untuk filter Published)
        $statusPublished = Status::firstOrCreate(['name' => 'Published'], ['slug' => 'published', 'color' => 'success']);
        $statusDraft = Status::firstOrCreate(['name' => 'Draft'], ['slug' => 'draft', 'color' => 'warning']);

        // 5. Buat Kategori (Sesuai Menu)
        $categories = [
            ['slug' => 'sulur', 'name' => 'Sulur', 'text_color' => '#9D174D', 'bg_color' => '#FCE7F3', 'description' => 'Menelusuri akar kisah yang mendalam.'],
            ['slug' => 'suluh', 'name' => 'Suluh', 'text_color' => '#065F46', 'bg_color' => '#D1FAE5', 'description' => 'Menjadi penerang dan inspirasi.'],
            ['slug' => 'singgah', 'name' => 'Singgah', 'text_color' => '#1E40AF', 'bg_color' => '#DBEAFE', 'description' => 'Tempat istirahat sejenak menikmati cerita ringan.'],
            ['slug' => 'taut', 'name' => 'Taut', 'text_color' => '#92400E', 'bg_color' => '#FEF3C7', 'description' => 'Menautkan rasa dan solidaritas bersama.'],
        ];

        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'text_color' => $cat['text_color'], 
                    'bg_color' => $cat['bg_color'],
                ]
            );

            // 6. ISI POSTINGAN UNTUK SETIAP KATEGORI
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
                    'notification_sent' => true, // Anggap notifikasi sudah dikirim
                ]);
            }
        }

        // 7. BUAT DATA TIM (Dapur Redaksi)
        TeamMember::firstOrCreate(['name' => 'Ida Ayu'], [
            'position' => 'Pemimpin Redaksi',
            'photo' => null, // Biarkan null agar muncul avatar default
            'sort_order' => 1
        ]);

        // 8. BUAT QUOTES
        Quote::create([
            'content' => 'Jadilah Suluh bagi sekitarmu.',
            'author' => 'Redaksi Mesuluh',
            'position' => 'sidebar',
            'is_active' => true
        ]);

        Quote::create([
            'content' => 'Sebab kami percaya dengan berkisah mampu menjadi suluh dalam merawat hingga meruwat kehidupan.',
            'author' => 'Mesuluh',
            'position' => 'home_featured',
            'is_active' => true
        ]);
        
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

        $this->command->info('Data berhasil dimasukkan!');
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