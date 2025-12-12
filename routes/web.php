<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use Illuminate\Http\Request;

Route::get('/', function () {
    // 1. Ambil artikel yang statusnya 'Published'
    // 2. Dan tanggal tayangnya sudah lewat (bukan masa depan)
    // 3. Urutkan dari yang terbaru
    // 4. Ambil 6 biji saja
    $posts = Post::query()
        ->with(['category', 'user']) // Eager load biar cepat
        ->whereHas('status', fn($q) => $q->where('name', 'Published'))
        ->where('published_at', '<=', now())
        ->latest('published_at')
        ->take(6)
        ->get();

    // Kirim data $posts ke halaman 'welcome'
    return view('welcome', [
        'posts' => $posts
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
Route::get('/search', function (Request $request) {
    $query = $request->input('q'); // Ambil kata kunci dari URL ?q=...

    // Jika kosong, kembalikan ke home
    if (!$query) {
        return redirect('/');
    }

    // Cari tulisan berdasarkan Judul ATAU Ringkasan
    // Yang statusnya Published
    $posts = Post::query()
        ->with('user', 'category')
        ->whereHas('status', fn($q) => $q->where('name', 'Published'))
        ->where('published_at', '<=', now())
        ->where(function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('excerpt', 'like', "%{$query}%")
              ->orWhere('content', 'like', "%{$query}%");
        })
        ->latest('published_at')
        ->paginate(9);

    return view('posts.search', [
        'posts' => $posts,
        'query' => $query
    ]);
})->name('posts.search');

// Route untuk halaman detail tulisan
// {post:slug} artinya kita mencari tulisan berdasarkan 'slug' (URL), bukan ID.
Route::get('/{post:slug}', function (Post $post) {
    
    // Logic: Jika tulisan belum publish, jangan kasih lihat (404)
    if ($post->status->name !== 'Published' || $post->published_at > now()) {
        abort(404);
    }

    // Hitung jumlah pembaca (View Counter) +1 setiap kali dibuka
    $post->increment('views');

    return view('posts.show', [
        'post' => $post
    ]);
})->name('posts.show');