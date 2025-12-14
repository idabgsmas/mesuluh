<x-layouts.app 
    :title="$searchKeyword ? 'Pencarian: ' . $searchKeyword : 'Indeks Tulisan'"
    description="Arsip lengkap tulisan Mesuluh dari berbagai rubrik."
>

    <div class="pt-32 pb-16 bg-mesuluh-cream border-b border-mesuluh-primary/10">
        <div class="container mx-auto px-4 text-center">
            
            <h1 class="font-serif text-4xl md:text-5xl font-bold text-mesuluh-dark mb-6">
                @if($searchKeyword)
                    Hasil Pencarian: <span class="text-mesuluh-primary italic">"{{ $searchKeyword }}"</span>
                @else
                    Indeks Tulisan
                @endif
            </h1>

            <div class="max-w-2xl mx-auto relative">
                <form action="{{ route('posts.search') }}" method="GET">
                    <input type="text" name="q" value="{{ $searchKeyword }}" 
                           placeholder="Ketik kata kunci yang ingin dicari..." 
                           class="w-full pl-6 pr-14 py-4 rounded-full border-2 border-mesuluh-primary/20 bg-white focus:border-mesuluh-primary focus:ring-0 text-lg shadow-sm transition outline-none text-mesuluh-dark font-sans placeholder-gray-400">
                    
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 bg-mesuluh-primary text-mesuluh-cream rounded-full hover:bg-mesuluh-dark transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>
            </div>

            <p class="mt-4 text-sm text-gray-500 font-sans">
                @if($searchKeyword)
                    Ditemukan {{ $posts->total() }} tulisan untuk kata kunci tersebut.
                @else
                    Menampilkan arsip lengkap tulisan Mesuluh dari yang terbaru.
                @endif
            </p>

        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @foreach($posts as $post)
                    <article class="flex flex-col group h-full">
                        <a href="{{ route('posts.show', $post) }}" class="block overflow-hidden rounded-2xl mb-5 relative aspect-[4/3] border border-gray-100 shadow-sm hover:shadow-lg transition duration-300">
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                            
                            <span style="color: {{ $post->category->text_color ?? '#9D174D' }}; background-color: {{ $post->category->bg_color ?? '#FCE7F3' }};"
                                  class="absolute top-4 left-4 px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md shadow-sm border border-white/50">
                                {{ $post->category->name }}
                            </span>
                        </a>

                        <div class="flex flex-col flex-grow">
                            <div class="text-xs text-gray-400 mb-3 font-sans flex items-center gap-2">
                                <span style="color: {{ $post->category->text_color ?? '#9D174D' }}" class="font-bold">
                                    {{ $post->user->name }}
                                </span>
                                <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                <span>{{ $post->published_at->format('d M Y') }}</span>
                            </div>
                            
                            <a href="{{ route('posts.show', $post) }}">
                                <h3 class="font-serif text-2xl font-bold text-mesuluh-dark leading-tight mb-3 group-hover:text-mesuluh-primary transition">
                                    {{ $post->title }}
                                </h3>
                            </a>

                            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed mb-4 flex-grow font-sans">
                                {{ $post->excerpt }}
                            </p>

                            <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center text-xs font-bold uppercase tracking-widest text-mesuluh-primary hover:underline underline-offset-4 decoration-2">
                                Baca Selengkapnya &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $posts->links() }} 
            </div>

        @else
            <div class="text-center py-20 opacity-60">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-gray-400">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <h3 class="font-serif text-xl text-gray-600 mb-2">Tidak ada tulisan ditemukan.</h3>
                <p class="text-sm text-gray-400 font-sans">Cobalah menggunakan kata kunci lain atau periksa ejaan Anda.</p>
                <a href="{{ route('posts.search') }}" class="inline-block mt-6 text-mesuluh-primary font-bold hover:underline text-sm">Lihat Semua Indeks</a>
            </div>
        @endif

    </div>

</x-layouts.app>