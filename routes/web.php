<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

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