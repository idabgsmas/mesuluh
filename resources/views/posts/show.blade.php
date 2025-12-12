<x-layouts.app :title="$post->title">

    <header class="pt-10 pb-10 text-center container mx-auto px-4 max-w-4xl">
        
        <div class="flex items-center justify-center gap-4 text-sm font-sans mb-6 text-gray-500">
            <span class="font-bold uppercase tracking-wider text-mesuluh-primary">
                {{ $post->category->name }}
            </span>
            <span>&bull;</span>
            <span>{{ $post->published_at->format('d F Y') }}</span>
        </div>

        <h1 class="font-serif text-4xl md:text-6xl font-bold text-mesuluh-dark mb-6 leading-tight">
            {{ $post->title }}
        </h1>

        <div class="flex items-center justify-center gap-3">
            @if($post->user->avatar)
                <img src="{{ asset('storage/' . $post->user->avatar) }}" class="w-10 h-10 rounded-full object-cover">
            @else
                <div class="w-10 h-10 rounded-full bg-mesuluh-primary/10 flex items-center justify-center text-mesuluh-primary font-bold">
                    {{ substr($post->user->name, 0, 1) }}
                </div>
            @endif
            <div class="text-left">
                <p class="font-bold text-sm text-mesuluh-dark">{{ $post->user->name }}</p>
                <p class="text-xs text-gray-500">{{ $post->user->bio ?? 'Penulis Mesuluh' }}</p>
            </div>
        </div>

    </header>

    <figure class="container mx-auto px-4 max-w-5xl mb-12">
        <img src="{{ asset('storage/' . $post->thumbnail) }}" 
             alt="{{ $post->title }}" 
             class="w-full h-auto rounded-xl shadow-lg">
    </figure>

    <article class="container mx-auto px-4 max-w-3xl">
        
        <div class="prose prose-lg prose-stone mx-auto font-sans text-gray-800 leading-relaxed">
            {!! $post->content !!}
        </div>

    </article>

    <div class="border-t border-mesuluh-primary/10 mt-16 py-12 text-center">
        <a href="/" class="text-mesuluh-primary font-bold hover:underline">
            &larr; Kembali ke Beranda
        </a>
    </div>

</x-layouts.app>