<x-layouts.app 
    :title="$category->name"
    :description="$category->description ?? 'Kumpulan tulisan dalam kategori ' . $category->name"
>

    <header class="bg-mesuluh-primary/5 py-16 text-center mb-12 border-b border-mesuluh-primary/10">
        <div class="container mx-auto px-4">
            <span class="text-mesuluh-primary font-bold tracking-widest uppercase text-xs mb-3 block">
                Kategori
            </span>
            <h1 class="font-serif text-5xl text-mesuluh-dark mb-4 capitalize">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-gray-600 max-w-2xl mx-auto font-sans">
                    {{ $category->description }}
                </p>
            @endif
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
            {{ $posts->links() }}
        </div>

        @if($posts->isEmpty())
            <div class="text-center py-20 opacity-50 border-2 border-dashed border-gray-200 rounded-xl">
                <p class="font-serif text-xl">Belum ada tulisan di kategori ini.</p>
            </div>
        @endif

    </section>

</x-layouts.app>