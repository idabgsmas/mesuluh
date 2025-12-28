<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\View\View;

class TagController extends Controller
{
    public function show(Tag $tag): View
    {
        // Ambil semua tulisan yang memiliki tag ini dan berstatus Published (3)
        $posts = $tag->posts()
            ->where('status_id', 3)
            ->latest('published_at')
            ->paginate(12);

        return view('tags.show', compact('tag', 'posts'));
    }
}