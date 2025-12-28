@section('seo')
    <title>Tag #{{ $tag->name }} | Mesuluh</title>
    <meta name="description" content="Kumpulan tulisan dengan tag #{{ $tag->name }} di Mesuluh.">
    
    <meta property="og:title" content="Tag #{{ $tag->name }} | Mesuluh">
    <meta property="og:description" content="Kumpulan tulisan dengan tag #{{ $tag->name }} di Mesuluh.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection

<x-layouts.app 
    :title="'Tag #' . $tag->name"
    :description="'Kumpulan tulisan dengan tag #' . $tag->name"
>
    {{-- Header Halaman Tag --}}
    <div class="pt-32 pb-16 bg-mesuluh-cream text-center px-4 relative">
        <div class="flex justify-center gap-2 text-xs font-bold tracking-widest uppercase text-gray-400 mb-6">
            <a href="/" class="hover:text-mesuluh-primary transition">Beranda</a>
            <span>/</span>
            <span class="text-mesuluh-dark">Tag</span>
        </div>

        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl font-bold text-mesuluh-dark leading-tight max-w-4xl mx-auto">
            #{{ $tag->name }}
        </h1>
        <p class="mt-4 text-gray-500 font-sans italic">Menampilkan {{ $posts->total() }} tulisan</p>
    </div>

    {{-- Daftar Artikel Berdasarkan Tag --}}
    <div class="container mx-auto px-4 py-16">
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post) }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100">
                        <div class="aspect-[4/3] overflow-hidden">
                             <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold text-mesuluh-primary uppercase tracking-wider">
                                {{ $post->category->name }}
                            </span>
                            <h4 class="font-serif font-bold text-lg text-mesuluh-dark leading-tight mt-1 mb-2 group-hover:text-mesuluh-primary transition">
                                {{ $post->title }}
                            </h4>
                            <p class="text-xs text-gray-500">{{ $post->published_at->format('d M Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        @else
            <div class="max-w-xl mx-auto text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="m15 5 4 4"/><path d="M13 7h8v10h-8Z"/><path d="M11 17H3V7h8Z"/><path d="m9 11-4 4"/><path d="m5 11 4 4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-mesuluh-dark mb-2">Belum ada tulisan</h3>
                <p class="text-gray-500">Saat ini belum ada artikel yang dikaitkan dengan tag ini.</p>
                <a href="/" class="inline-block mt-8 text-mesuluh-primary font-bold hover:underline">&larr; Kembali ke Beranda</a>
            </div>
        @endif
    </div>
</x-layouts.app>