<x-layouts.app :title="'Pencarian: ' . $query">

    <header class="bg-mesuluh-primary/5 py-16 text-center mb-12 border-b border-mesuluh-primary/10">
        <div class="container mx-auto px-4">
            <span class="text-gray-500 font-sans tracking-widest uppercase text-xs mb-3 block">
                Menampilkan hasil pencarian untuk:
            </span>
            <h1 class="font-serif text-3xl md:text-5xl text-mesuluh-dark mb-4">
                "{{ $query }}"
            </h1>
            <p class="text-sm text-gray-500 font-sans">
                Ditemukan {{ $posts->total() }} tulisan.
            </p>
        </div>
    </header>

    <section class="container mx-auto px-4 pb-20">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <article class="group flex flex-col h-full bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-mesuluh-primary/5">
                    
                    <div class="h-48 overflow-hidden relative">
                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </a>
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

        <div class="mt-12">
            {{ $posts->appends(['q' => $query])->links() }}
        </div>

        @if($posts->isEmpty())
            <div class="text-center py-20">
                <div class="mb-4 text-mesuluh-primary/20">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-24 h-24 mx-auto">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <p class="font-serif text-xl text-mesuluh-dark">Maaf, tidak ditemukan tulisan dengan kata kunci tersebut.</p>
                <p class="text-gray-500 mt-2">Coba gunakan kata kunci lain.</p>
            </div>
        @endif

    </section>

</x-layouts.app>