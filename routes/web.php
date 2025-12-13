<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    // 1. Featured (Slider)
    $featuredPosts = Post::with(['user', 'category'])
        ->whereHas('status', fn($q) => $q->where('name', 'Published'))
        ->where('published_at', '<=', now())
        ->where('is_featured', true)
        ->latest('published_at')
        ->take(5)
        ->get();
    
    // ID yang sudah muncul di slider, jangan dimunculkan lagi di bawah
    $excludeIds = $featuredPosts->pluck('id');

    // 2. Tulisan Terbaru (Untuk Kolom Kiri)
    $latestPosts = Post::with(['user', 'category'])
        ->whereHas('status', fn($q) => $q->where('name', 'Published'))
        ->where('published_at', '<=', now())
        ->whereNotIn('id', $excludeIds)
        ->latest('published_at')
        ->take(6) 
        ->get();
    
    // Update exclude IDs (biar ga dobel sama yang terbaru)
    $excludeIds = $excludeIds->merge($latestPosts->pluck('id'));

    // 3. Tulisan Terpopuler (Berdasarkan jumlah 'views')
    $popularPosts = Post::with(['user', 'category'])
        ->whereHas('status', fn($q) => $q->where('name', 'Published'))
        ->where('published_at', '<=', now())
        ->orderBy('views', 'desc') // Urutkan dari view terbanyak
        ->take(5)
        ->get();

    // 4. AMBIL SEMUA RUBRIK (KATEGORI)
    // Ambil kategori yang punya minimal 1 postingan published
    $rubrics = Category::whereHas('posts', fn($q) => $q->whereHas('status', fn($sq) => $sq->where('name', 'Published')))
        ->with(['posts' => function($query) {
            // Ambil 4 postingan terbaru per kategori
            $query->whereHas('status', fn($q) => $q->where('name', 'Published'))
                  ->where('published_at', '<=', now())
                  ->latest('published_at')
                  ->take(4);
        }])
        ->get();

    return view('welcome', [
        'featuredPosts' => $featuredPosts,
        'latestPosts' => $latestPosts,   // Perhatikan nama variabelnya saya ganti jadi latestPosts
        'popularPosts' => $popularPosts,
        'rubrics' => $rubrics,
        // 'sulurPosts' => $sulurPosts,
        // 'suluhPosts' => $suluhPosts,
        // 'singgahPosts' => $singgahPosts,
        // 'tautPosts' => $tautPosts,
    ]);
});

// Route Halaman Tentang
Route::view('/tentang-kami', 'pages.about')->name('about');

// Route Halaman Kategori
Route::get('/kategori/{category:slug}', function (Category $category) {
    
    // Ambil tulisan dalam kategori ini, yang statusnya Published, dan beri Halaman (Pagination)
    $posts = $category->posts()
        ->with('user')
        ->whereHas('status', fn($q) => $q->where('name', 'Published'))
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->paginate(9); // Tampilkan 9 tulisan per halaman

    return view('posts.category', [
        'category' => $category,
        'posts' => $posts
    ]);
})->name('posts.category');

// Route Pencarian
// Route::get('/search', function (Request $request) {
//     $query = $request->input('q'); // Ambil kata kunci dari URL ?q=...

//     // Jika kosong, kembalikan ke home
//     if (!$query) {
//         return redirect('/');
//     }

//     // Cari tulisan berdasarkan Judul ATAU Ringkasan
//     // Yang statusnya Published
//     $posts = Post::query()
//         ->with('user', 'category')
//         ->whereHas('status', fn($q) => $q->where('name', 'Published'))
//         ->where('published_at', '<=', now())
//         ->where(function($q) use ($query) {
//             $q->where('title', 'like', "%{$query}%")
//               ->orWhere('excerpt', 'like', "%{$query}%")
//               ->orWhere('content', 'like', "%{$query}%");
//         })
//         ->latest('published_at')
//         ->paginate(9);

//     return view('posts.search', [
//         'posts' => $posts,
//         'query' => $query
//     ]);
// })->name('posts.search');

// Route Halaman Indeks & Pencarian
Route::get('/indeks', [PostController::class, 'index'])->name('posts.search');

// Route untuk halaman detail tulisan
// {post:slug} artinya kita mencari tulisan berdasarkan 'slug' (URL), bukan ID.
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Route untuk menyimpan subscriber
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe.store');