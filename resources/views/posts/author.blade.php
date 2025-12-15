<x-layouts.app 
    :title="$author->name"
    :description="'Arsip tulisan oleh ' . $author->name"
    :image="$author->avatar ? asset('storage/' . $author->avatar) : null"
>

    <div class="pt-32 pb-16 bg-mesuluh-cream border-b border-mesuluh-primary/10">
        <div class="container mx-auto px-4 text-center">
            
            <div class="relative inline-block mb-6 group">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl overflow-hidden relative z-10">
                    @if($author->avatar)
                        <img src="{{ asset('storage/' . $author->avatar) }}" 
                             alt="{{ $author->name }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full bg-mesuluh-primary text-mesuluh-cream flex items-center justify-center text-5xl font-serif font-bold">
                            {{ substr($author->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="absolute top-0 -right-4 w-20 h-20 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute -bottom-2 -left-4 w-20 h-20 bg-mesuluh-primary/20 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            </div>

            <h1 class="font-serif text-3xl md:text-5xl font-bold text-mesuluh-dark mb-3">
                {{ $author->name }}
            </h1>
            
            <div class="flex items-center justify-center gap-2 mb-6">
                <span class="px-3 py-1 bg-mesuluh-primary/10 text-mesuluh-primary text-xs font-bold uppercase tracking-widest rounded-full">
                    Penulis Mesuluh
                </span>
            </div>

            <p class="text-gray-600 max-w-xl mx-auto font-sans text-lg leading-relaxed">
                {{ $author->bio ?? 'Menulis sepenuh hati untuk menyuarakan apa yang acap kali terbungkam di sudut-sudut pulau Dewata.' }}
            </p>

            <div class="mt-8 flex items-center justify-center gap-8 md:gap-12 border-t border-mesuluh-primary/10 pt-8 max-w-xs mx-auto">
                
                <div class="flex flex-col animate-fade-in-up">
                    <span class="text-3xl font-serif font-bold text-mesuluh-dark">
                        {{ $author->posts()->where('status_id', 3)->count() }}
                    </span>
                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">
                        Tulisan
                    </span>
                </div>

                <div class="w-px h-10 bg-mesuluh-primary/20"></div>

                <div class="flex flex-col animate-fade-in-up delay-100">
                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">
                        Bergabung Sejak
                    </span>
                    <span class="text-3xl font-serif font-bold text-mesuluh-dark">
                        {{ $author->created_at->format('d M Y') }}
                    </span>
                </div>

            </div>
            
            <div class="mt-6">
                <a href="mailto:{{ $author->email }}" class="inline-flex items-center gap-2 text-xs font-bold text-mesuluh-primary hover:text-mesuluh-dark transition bg-white px-4 py-2 rounded-full border border-mesuluh-primary/20 hover:border-mesuluh-primary shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                      <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                      <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                    </svg>
                    Sapa Penulis
                </a>
            </div>

        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-8">
                
                @if($featured)
                    <div class="mb-12">
                        <article class="group relative rounded-2xl overflow-hidden shadow-lg aspect-video md:aspect-[2/1]">
                            <a href="{{ route('posts.show', $featured) }}">
                                <img src="{{ asset('storage/' . $featured->thumbnail) }}" 
                                     alt="{{ $featured->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            </a>
                            
                            <div class="absolute bottom-0 left-0 p-6 md:p-8 w-full">
                                <div class="flex items-center gap-3 text-white/80 text-xs font-bold mb-3">
                                    <span style="background-color: {{ $featured->category->text_color ?? '#9D174D' }}" class="text-white px-2 py-1 rounded">
                                        {{ $featured->category->name }}
                                    </span>
                                    <span>{{ $featured->published_at->format('d M Y') }}</span>
                                </div>
                                <a href="{{ route('posts.show', $featured) }}">
                                    <h2 class="font-serif text-2xl md:text-4xl font-bold text-white leading-tight group-hover:text-mesuluh-cream transition">
                                        {{ $featured->title }}
                                    </h2>
                                </a>
                                <p class="text-white/90 mt-3 line-clamp-2 hidden md:block max-w-2xl">
                                    {{ $featured->excerpt }}
                                </p>
                            </div>
                        </article>
                    </div>

                    <div class="flex items-center gap-4 mb-8">
                        <h3 class="font-bold text-xl text-mesuluh-dark font-serif">Arsip Tulisan</h3>
                        <div class="h-px bg-gray-200 flex-grow"></div>
                    </div>

                    @if($posts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-8">
                            @foreach($posts as $post)
                                <article class="flex flex-col group h-full">
                                    <a href="{{ route('posts.show', $post) }}" class="block overflow-hidden rounded-2xl mb-4 relative aspect-[4/3]">
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-105 transition duration-700">
                                    </a>
                                    
                                    <div class="flex flex-col flex-grow">
                                        <div class="text-xs text-gray-500 mb-2 flex items-center gap-2 font-sans">
                                            <span style="color: {{ $post->category->text_color ?? '#9D174D' }}" class="font-bold">
                                                {{ $post->category->name }}
                                            </span>
                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span>{{ $post->published_at->format('d M Y') }}</span>
                                        </div>
                                        
                                        <a href="{{ route('posts.show', $post) }}" class="mb-2 block">
                                            <h3 class="font-serif text-xl font-bold text-mesuluh-dark leading-snug group-hover:text-mesuluh-primary transition">
                                                {{ $post->title }}
                                            </h3>
                                        </a>

                                        <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed mb-4 font-sans">
                                            {{ $post->excerpt }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-12">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ada tulisan lain dari penulis ini.</p>
                    @endif

                @else
                    <div class="text-center py-20 opacity-50 border-2 border-dashed border-gray-200 rounded-xl">
                        <p class="font-serif text-xl">Penulis ini belum menerbitkan tulisan.</p>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-4 space-y-10">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-32">
                    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                        <h3 class="font-serif text-lg font-bold text-mesuluh-dark">Terpopuler dari {{ explode(' ', $author->name)[0] }}</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-mesuluh-primary" viewBox="0 0 20 20" fill="currentColor"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" /></svg>
                    </div>

                    <div class="space-y-6">
                        @forelse($popularPosts as $pop)
                            <article class="group flex gap-4 items-start">
                                <span class="text-3xl font-serif font-bold text-gray-200 -mt-2 group-hover:text-mesuluh-primary transition">
                                    {{ $loop->iteration }}
                                </span>
                                <div>
                                    <div style="color: {{ $pop->category->text_color ?? '#9D174D' }}"
                                         class="text-[10px] font-bold uppercase tracking-wider mb-1">
                                        {{ $pop->category->name }}
                                    </div>
                                    <a href="{{ route('posts.show', $pop) }}">
                                        <h4 class="font-bold text-mesuluh-dark leading-snug group-hover:text-mesuluh-primary transition">
                                            {{ $pop->title }}
                                        </h4>
                                    </a>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-gray-400">{{ $pop->published_at->format('d M Y') }}</span>
                                        <span class="text-[10px] bg-gray-100 px-1.5 py-0.5 rounded text-gray-500">{{ $pop->views }} views</span>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada data tulisan populer.</p>
                        @endforelse
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <p class="text-xs text-gray-400 mb-3">Dukung tulisan {{ $author->name }}?</p>
                        <button onclick="navigator.share({title: '{{ $author->name }} di Mesuluh', url: '{{ url()->current() }}'})" class="block w-full py-2 bg-mesuluh-cream text-mesuluh-primary font-bold text-xs rounded-lg hover:bg-mesuluh-primary hover:text-white transition">
                            Bagikan Profil Ini
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>

</x-layouts.app>