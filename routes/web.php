<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TagController;

// Route untuk ganti bahasa
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back(); // Kembali ke halaman sebelumnya
})->name('switch.language');

// Route Halaman Beranda
Route::get('/', [App\Http\Controllers\PostController::class, 'welcome'])->name('welcome');

// Route::get('/', function () {
//     // 1. Featured (Slider)
//     $featuredPosts = Post::with(['user', 'category'])
//         ->whereHas('status', fn($q) => $q->where('name', 'Published'))
//         ->where('published_at', '<=', now())
//         ->where('is_featured', true)
//         ->latest('published_at')
//         ->take(5)
//         ->get();
    
//     // ID yang sudah muncul di slider, jangan dimunculkan lagi di bawah
//     $excludeIds = $featuredPosts->pluck('id');

//     // 2. Tulisan Terbaru (Untuk Kolom Kiri)
//     $latestPosts = Post::with(['user', 'category'])
//         ->whereHas('status', fn($q) => $q->where('name', 'Published'))
//         ->where('published_at', '<=', now())
//         ->whereNotIn('id', $excludeIds)
//         ->latest('published_at')
//         ->take(6) 
//         ->get();
    
//     // Update exclude IDs (biar ga dobel sama yang terbaru)
//     $excludeIds = $excludeIds->merge($latestPosts->pluck('id'));

//     // 3. Tulisan Terpopuler (Berdasarkan jumlah 'views')
//     $popularPosts = Post::with(['user', 'category'])
//         ->whereHas('status', fn($q) => $q->where('name', 'Published'))
//         ->where('published_at', '<=', now())
//         ->orderBy('views', 'desc') // Urutkan dari view terbanyak
//         ->take(5)
//         ->get();

//     // 4. AMBIL SEMUA RUBRIK (KATEGORI)
//     // Ambil kategori yang punya minimal 1 postingan published
//     $rubrics = Category::whereHas('posts', fn($q) => $q->whereHas('status', fn($sq) => $sq->where('name', 'Published')))
//         ->with(['posts' => function($query) {
//             // Ambil 4 postingan terbaru per kategori
//             $query->whereHas('status', fn($q) => $q->where('name', 'Published'))
//                   ->where('published_at', '<=', now())
//                   ->latest('published_at')
//                   ->take(4);
//         }])
//         ->get();

//     return view('welcome', [
//         'featuredPosts' => $featuredPosts,
//         'latestPosts' => $latestPosts,   // Perhatikan nama variabelnya saya ganti jadi latestPosts
//         'popularPosts' => $popularPosts,
//         'rubrics' => $rubrics,
//         // 'sulurPosts' => $sulurPosts,
//         // 'suluhPosts' => $suluhPosts,
//         // 'singgahPosts' => $singgahPosts,
//         // 'tautPosts' => $tautPosts,
//     ]);
// });

// Route Daftar Semua Penulis
Route::get('/penulis', [PostController::class, 'authors'])->name('authors.index');

// Route Halaman Profil Penulis
Route::get('/penulis/{user}', [PostController::class, 'author'])->name('posts.author');

// Route Halaman Tentang
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');

// Route Halaman Pedoman Media Siber
Route::get('/pedoman-media-siber', [PageController::class, 'pedoman'])->name('pedoman');

// Route Halaman Kontak
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

// Route Kirim Pesan (POST) Kontak
Route::post('/kontak', [PageController::class, 'storeContact'])->name('contact.store');

// Route Halaman Kategori
// Panggil Controller yang sudah kita buat tadi
Route::get('/kategori/{category:slug}', [PostController::class, 'category'])->name('posts.category');
// Route::get('/kategori/{category:slug}', function (Category $category) {
    
//     // Ambil tulisan dalam kategori ini, yang statusnya Published, dan beri Halaman (Pagination)
//     $posts = $category->posts()
//         ->with('user')
//         ->whereHas('status', fn($q) => $q->where('name', 'Published'))
//         ->where('published_at', '<=', now())
//         ->latest('published_at')
//         ->paginate(9); // Tampilkan 9 tulisan per halaman

//     return view('posts.category', [
//         'category' => $category,
//         'posts' => $posts
//     ]);
// })->name('posts.category');

// Route Halaman Indeks & Pencarian
Route::get('/indeks', [PostController::class, 'index'])->name('posts.search');

// Route untuk halaman detail tulisan
// {post:slug} artinya kita mencari tulisan berdasarkan 'slug' (URL), bukan ID.
Route::get('/tulisan/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Route untuk menyimpan subscriber
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe.store');

// Route untuk menampilkan artikel berdasarkan Tag
Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tags.show');