<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Menampilkan Halaman Detail Artikel
     */
    public function show(Post $post)
    {
        // Tambahkan validasi keamanan ini di paling atas
        if ($post->status_id != 3 || ($post->published_at > now() && !auth()->check())) {
            abort(404); // Tampilkan error 404 jika belum waktunya tayang
        }

        // 1. Tambah views
        $post->increment('views');

        // 2. Ambil Related Posts (Untuk ditaruh di BAWAH artikel)
        $relatedPosts = Post::with(['user', 'category'])
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->whereHas('status', fn($q) => $q->where('name', 'Published'))
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(4) // Ambil 4 biar genap grid-nya
            ->get();

        // 3. Ambil Latest Posts (Untuk SIDEBAR KANAN) - BARU
        $latestPosts = Post::with(['user', 'category'])
            ->where('id', '!=', $post->id) // Jangan tampilkan post yg sedang dibaca
            ->whereHas('status', fn($q) => $q->where('name', 'Published'))
            ->where('published_at', '<=', now())
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
            ->whereHas('status', fn($q) => $q->where('name', 'Published'))
            ->where('published_at', '<=', now());

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

    /**
     * Menampilkan Halaman Kategori
     */
    public function category(Category $category)
    {
        // DEFINISI FILTER DASAR:
        // 1. Status harus 'Published'
        // 2. Waktu published_at harus sudah lewat atau sekarang (bukan jadwal masa depan)
        $baseQuery = $category->posts()
            ->whereHas('status', fn($q) => $q->where('name', 'Published'))
            ->where('published_at', '<=', now());

        // 1. AMBIL HERO POST (POSTINGAN UTAMA)
        // Prioritas: Postingan yang dicentang 'is_featured'
        // FIX: Menggunakan latest('published_at')
        $featured = (clone $baseQuery)
                             ->where('is_featured', true)
                             ->latest('published_at') 
                             ->first();

        // Fallback: Jika tidak ada yang featured, ambil postingan terbaru biasa
        if (!$featured) {
            $featured = (clone $baseQuery)
                        ->latest('published_at')
                        ->first();
        }

        // 2. AMBIL LIST POSTINGAN (SISANYA)
        // Ambil semua kecuali yang sudah dijadikan Featured
        // FIX: Menggunakan latest('published_at')
        $posts = (clone $baseQuery)
                          ->when($featured, function ($query) use ($featured) {
                              return $query->where('id', '!=', $featured->id);
                          })
                          ->latest('published_at') // <--- INI KUNCINYA
                          ->paginate(10); 

        // 3. AMBIL PILIHAN EDITOR (SIDEBAR)
        // Ambil dari Global Post (bukan cuma kategori ini)
        $editorsChoice = Post::with('category')
                             ->whereHas('status', fn($q) => $q->where('name', 'Published'))
                             ->where('published_at', '<=', now())
                             ->where('is_featured', true)
                             ->when($featured, function ($query) use ($featured) {
                                 return $query->where('id', '!=', $featured->id);
                             })
                             ->latest('published_at') // Pilihan editor juga urut tanggal terbit
                             ->limit(5)
                             ->get();

        return view('posts.category', [
            'category' => $category,
            'featured' => $featured,
            'posts' => $posts,
            'editorsChoice' => $editorsChoice,
        ]);
    }

    /**
     * Menampilkan Daftar Semua Penulis
     */
    public function authors()
    {
        // Ambil user yang punya minimal 1 postingan Published
        // DAN Role-nya adalah Editor (2) atau Penulis (3)
        $authors = User::whereIn('role_id', [2, 3])
            ->whereHas('posts', fn($q) => $q->whereHas('status', fn($sq) => $sq->where('name', 'Published')))
            ->withCount(['posts' => fn($q) => $q->whereHas('status', fn($sq) => $sq->where('name', 'Published'))]) // Hitung jumlah tulisan
            ->orderBy('name', 'asc') // Urutkan nama A-Z
            ->get();

        return view('posts.authors_index', [
            'authors' => $authors
        ]);
    }

    /**
     * Menampilkan Halaman Profil Penulis dan Tulisan-tulisannya
     */
    public function author(User $user)
    {
        // Query Dasar: Ambil post milik user ini yang sudah Published
        $baseQuery = $user->posts()
            ->with('category')
            ->whereHas('status', fn($q) => $q->where('name', 'Published'))
            ->where('published_at', '<=', now());

        // 1. AMBIL HERO POST (Khusus Penulis Ini)
        // Cek apakah penulis punya tulisan yang di-set 'is_featured'
        $featured = (clone $baseQuery)
                             ->where('is_featured', true)
                             ->latest('published_at') 
                             ->first();

        // Jika tidak ada yang featured, ambil tulisan paling baru sebagai Hero
        if (!$featured) {
            $featured = (clone $baseQuery)
                        ->latest('published_at')
                        ->first();
        }

        // 2. AMBIL LIST TULISAN (Sisanya)
        $posts = (clone $baseQuery)
                          ->when($featured, function ($query) use ($featured) {
                              return $query->where('id', '!=', $featured->id);
                          })
                          ->latest('published_at')
                          ->paginate(10); 

        // 3. AMBIL TULISAN TERPOPULER (Khusus Penulis Ini) - Untuk Sidebar
        $popularPosts = (clone $baseQuery)
                             ->orderBy('views', 'desc') // Urutkan berdasarkan views terbanyak
                             ->limit(5)
                             ->get();

        return view('posts.author', [
            'author' => $user,
            'featured' => $featured,
            'posts' => $posts,
            'popularPosts' => $popularPosts,
        ]);
    }

    // Nanti function untuk Search, Arsip Kategori, dll bisa ditambahkan di bawah sini...
}