<x-layouts.app 
    title="Redaksi Mesuluh"
    description="Mengenal para penulis dan kontributor yang menghidupkan kisah-kisah di Mesuluh."
>

    <div class="pt-32 pb-16 bg-mesuluh-cream border-b border-mesuluh-primary/10">
        <div class="container mx-auto px-4 text-center">
            <span class="text-mesuluh-primary font-bold tracking-widest uppercase text-xs mb-3 inline-block bg-mesuluh-primary/5 px-3 py-1 rounded-full border border-mesuluh-primary/10">
                Dapur Redaksi
            </span>
            <h1 class="font-serif text-4xl md:text-5xl font-bold text-mesuluh-dark mb-4">
                Penulis Kami
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto font-sans text-lg">
                Orang-orang yang merawat ingatan dan merekam jejak kehidupan lewat kata-kata.
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16">
        
        @if($authors->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($authors as $author)
                    <div class="group relative bg-white border border-gray-100 rounded-2xl p-8 text-center hover:shadow-lg hover:-translate-y-1 transition duration-300">
                        
                        <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border-2 border-mesuluh-cream mb-6 relative z-10">
                            @if($author->avatar)
                                <img src="{{ asset('storage/' . $author->avatar) }}" 
                                     alt="{{ $author->name }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full bg-mesuluh-primary text-mesuluh-cream flex items-center justify-center text-3xl font-serif font-bold">
                                    {{ substr($author->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <h3 class="font-serif text-xl font-bold text-mesuluh-dark mb-2">
                            <a href="{{ route('posts.author', $author) }}">
                                <span class="absolute inset-0"></span> {{ $author->name }}
                            </a>
                        </h3>
                        
                        <p class="text-xs font-bold uppercase tracking-widest text-mesuluh-primary mb-4">
                            {{ $author->posts_count }} Tulisan
                        </p>

                        <p class="text-gray-500 text-sm line-clamp-2 font-sans leading-relaxed">
                            {{ $author->bio ?? $author->role->name . ' di Mesuluh.' }}
                        </p>

                        <div class="mt-6 pt-6 border-t border-gray-50 opacity-0 group-hover:opacity-100 transition duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <a href="{{ route('posts.author', $author) }}" class="text-xs font-bold text-mesuluh-dark group-hover:text-mesuluh-primary flex items-center justify-center gap-1">
                                Lihat Profil <span class="text-lg leading-none">&rarr;</span>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 opacity-50">
                <p class="font-serif text-xl">Belum ada penulis yang terdaftar.</p>
            </div>
        @endif

    </div>

    <section class="bg-mesuluh-cream py-16 border-t border-mesuluh-primary/10">
        <div class="container mx-auto px-4 text-center">
            <h2 class="font-serif text-2xl md:text-3xl text-mesuluh-dark mb-4">Ingin Menjadi Kontributor?</h2>
            <p class="text-gray-600 max-w-xl mx-auto mb-8">
                Kami selalu terbuka untuk suara-suara baru. Kirimkan tulisan Anda dan jadilah bagian dari keluarga Mesuluh.
            </p>
            <a href="{{ route('contact') }}" class="inline-block px-8 py-3 bg-mesuluh-primary text-white font-bold rounded-full hover:bg-mesuluh-dark transition shadow-md">
                Kirim Tulisan
            </a>
        </div>
    </section>

</x-layouts.app>