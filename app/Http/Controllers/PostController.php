<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Menampilkan Halaman Detail Artikel
     */
    public function show(Post $post)
    {
        // 1. Tambah views
        $post->increment('views');

        // 2. Ambil Related Posts (Untuk ditaruh di BAWAH artikel)
        $relatedPosts = Post::with(['user', 'category'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->whereHas('status', fn($q) => $q->where('name', 'Published'))
            ->latest('published_at')
            ->take(4) // Ambil 4 biar genap grid-nya
            ->get();

        // 3. Ambil Latest Posts (Untuk SIDEBAR KANAN) - BARU
        $latestPosts = Post::with(['user', 'category'])
            ->where('id', '!=', $post->id) // Jangan tampilkan post yg sedang dibaca
            ->whereHas('status', fn($q) => $q->where('name', 'Published'))
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('posts.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'latestPosts' => $latestPosts, // Kirim data baru ini
        ]);
    }

    /**
     * Menampilkan Halaman Indeks / Hasil Pencarian
     */
    public function index(Request $request)
    {
        // Mulai Query: Ambil Post yang Published
        $query = Post::with(['user', 'category'])
            ->whereHas('status', fn($q) => $q->where('name', 'Published'));

        // Cek: Apakah ada kata kunci pencarian ('q')?
        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%")
                  ->orWhere('excerpt', 'like', "%{$keyword}%");
            });
        }

        // Ambil data (Pagination 9 item per halaman)
        $posts = $query->latest('published_at')->paginate(9)->withQueryString();

        return view('posts.index', [
            'posts' => $posts,
            'searchKeyword' => $request->q // Kirim kata kunci ke view untuk ditampilkan
        ]);
    }

    // Nanti function untuk Search, Arsip Kategori, dll bisa ditambahkan di bawah sini...
}