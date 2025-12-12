<x-layouts.app title="Beranda">
    
    <section class="py-20 text-center container mx-auto px-4">
        <span class="text-mesuluh-primary font-bold tracking-widest uppercase text-sm mb-4 block">
            Media Organik Perempuan Bali
        </span>
        
        <h1 class="font-serif text-5xl md:text-7xl text-mesuluh-dark mb-6 leading-tight">
            Berkisah sebagai <br> <span class="text-mesuluh-primary italic">Suluh Kehidupan</span>
        </h1>
        
        <p class="text-lg md:text-xl max-w-2xl mx-auto text-gray-600 mb-10">
            Membahas kisah-kisah dari sudut ke sudut, dari desa hingga kota dengan jujur.
        </p>

        <a href="#" class="inline-block bg-mesuluh-primary text-white px-8 py-3 rounded-full font-medium hover:bg-opacity-90 transition">
            Baca Tulisan Terbaru
        </a>
    </section>

    <section class="py-16 container mx-auto px-4">
        
        <div class="flex items-center justify-between mb-10">
            <h2 class="font-serif text-3xl text-mesuluh-dark">Tulisan Terbaru</h2>
            <a href="#" class="text-mesuluh-primary hover:underline font-medium">Lihat Semua →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <article class="group flex flex-col h-full bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-mesuluh-primary/5">
                    
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        
                        <span class="absolute top-4 left-4 bg-mesuluh-cream text-mesuluh-primary text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                            {{ $post->category->name }}
                        </span>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div class="text-xs text-gray-500 mb-3 flex items-center gap-2 font-sans">
                            <span>{{ $post->published_at->format('d M Y') }}</span>
                            <span>•</span>
                            <span>{{ $post->user->name }}</span>
                        </div>

                        <a href="{{ route('posts.show', $post) }}" class="block mb-3">
                            <h3 class="font-serif text-xl font-bold text-mesuluh-dark group-hover:text-mesuluh-primary transition line-clamp-2 leading-snug">
                                {{ $post->title }}
                            </h3>
                        </a>

                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow font-sans">
                            {{ $post->excerpt }}
                        </p>

                        <a href="{{ route('posts.show', $post) }}" class="text-mesuluh-primary text-sm font-bold tracking-wide uppercase hover:underline mt-auto">
                            Baca Selengkapnya
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        @if($posts->isEmpty())
            <div class="text-center py-20 opacity-50">
                <p class="font-serif text-xl">Belum ada tulisan yang terbit.</p>
                <p class="text-sm">Silakan publish tulisan dari dashboard admin.</p>
            </div>
        @endif

    </section>

</x-layouts.app>