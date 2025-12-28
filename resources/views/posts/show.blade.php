@section('seo')
    <title>{{ $post->seo_title ?? $post->title }} | Mesuluh</title>
    <meta name="description" content="{{ $post->seo_description ?? Str::limit(strip_tags($post->content), 150) }}">
    
    <meta property="og:title" content="{{ $post->seo_title ?? $post->title }}">
    <meta property="og:description" content="{{ $post->seo_description ?? Str::limit(strip_tags($post->content), 150) }}">
    <meta property="og:image" content="{{ $post->seo_image ? asset('storage/'.$post->seo_image) : asset('storage/'.$post->thumbnail) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
@endsection

<x-layouts.app 
    :title="$post->title"
    :description="$post->excerpt"
    :image="asset('storage/' . $post->thumbnail)"
>
    
    <div class="pt-32 pb-10 bg-mesuluh-cream text-center px-4 relative">
        <div class="flex justify-center gap-2 text-xs font-bold tracking-widest uppercase text-gray-400 mb-6">
            <a href="/" class="hover:text-mesuluh-primary">Beranda</a>
            <span>/</span>
            <a href="{{ route('posts.category', $post->category->slug) }}" class="hover:text-mesuluh-primary">{{ $post->category->name }}</a>
        </div>

        <a href="{{ route('posts.category', $post->category->slug) }}" 
           class="inline-block px-3 py-1 bg-mesuluh-primary/10 text-mesuluh-primary rounded-full text-xs font-bold tracking-wider uppercase mb-4 hover:bg-mesuluh-primary hover:text-white transition">
            {{ $post->category->name }}
        </a>

        <h1 class="font-serif text-3xl md:text-5xl lg:text-6xl font-bold text-mesuluh-dark leading-tight max-w-4xl mx-auto mb-6">
            {{ $post->title }}
        </h1>

        <div class="flex items-center justify-center gap-4 text-sm text-gray-500 font-sans">
            <span class="font-bold text-mesuluh-dark">Oleh {{ $post->user->name }}</span>
            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
            <span>{{ $post->published_at->format('d F Y') }}</span>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-6 mb-12">
        <div class="w-full aspect-[16/9] md:aspect-[21/9] rounded-2xl overflow-hidden shadow-2xl relative group">
            <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-1000">
        </div>
        @if($post->caption) 
            <p class="text-center text-xs text-gray-500 mt-3 italic">{{ $post->caption }}</p>
        @endif
    </div>

    <div class="container mx-auto px-4 pb-20">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            
            <div class="lg:w-2/3">
                
                <article class="prose prose-lg max-w-none 
                    prose-headings:font-serif prose-headings:text-mesuluh-dark 
                    prose-p:text-gray-800 prose-p:leading-loose prose-p:font-sans 
                    prose-a:text-mesuluh-primary prose-a:no-underline hover:prose-a:underline
                    prose-blockquote:border-l-4 prose-blockquote:border-mesuluh-primary prose-blockquote:bg-gray-50 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:not-italic
                    prose-img:rounded-xl">
                    
                    <p class="lead font-medium text-xl text-mesuluh-dark mb-8 border-l-4 border-mesuluh-primary pl-6 italic font-serif">
                        {{ $post->excerpt }}
                    </p>

                    {{-- {!! $post->content !!} --}}

                    <div x-data="{ isOpen: false, imgSource: '', imgCaption: '' }" class="relative">
    
                        {{-- Konten Tulisan dengan Pencegah Klik Default --}}
                        <div class="custom-content prose prose-lg max-w-none" 
                            @click="
                                let target = $event.target;
                                {{-- Cari apakah yang diklik adalah IMG atau link yang berisi IMG --}}
                                let clickableImg = target.tagName === 'IMG' ? target : target.closest('a')?.querySelector('img');
                                
                                if (clickableImg) {
                                    {{-- STOP! Jangan buka tab baru --}}
                                    $event.preventDefault(); 
                                    $event.stopPropagation();
                                    
                                    imgSource = clickableImg.src;
                                    {{-- Ambil caption dari figcaption terdekat --}}
                                    imgCaption = clickableImg.closest('figure')?.querySelector('figcaption')?.innerText || '';
                                    isOpen = true;
                                }
                            ">
                            {!! $post->content !!}
                        </div>

                        {{-- Lightbox Modal (Pop-up) --}}
                        <template x-teleport="body">
                            <div x-show="isOpen" 
                                x-transition.opacity.duration.300ms
                                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/90 p-4"
                                @click="isOpen = false"
                                @keydown.window.escape="isOpen = false"
                                style="display: none;">
                                
                                {{-- Tombol Tutup --}}
                                <button class="absolute top-6 right-6 text-white text-5xl font-light hover:text-gray-400">&times;</button>
                                
                                <div class="relative max-w-5xl w-full flex flex-col items-center" @click.stop>
                                    {{-- Gambar dalam Pop-up --}}
                                    <img :src="imgSource" class="max-w-full max-h-[80vh] rounded shadow-2xl object-contain border border-white/10">
                                    
                                    {{-- Caption dalam Pop-up (Tengah Bawah) --}}
                                    <div x-show="imgCaption" class="mt-6 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full">
                                        <p x-text="imgCaption" class="text-white text-center text-sm md:text-base italic"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <style>
                        /* 1. Paksa Container Utama Konten */
                        .custom-content {
                            width: 100% !important;
                            max-width: 100% !important;
                        }

                        /* 2. Targetkan Figure dan Lampiran Gambar */
                        .custom-content figure, 
                        .custom-content .attachment,
                        .custom-content .attachment--preview {
                            display: block !important;
                            margin: 2.5rem 0 !important; /* Jarak atas bawah, kiri kanan mepet */
                            width: 100% !important;
                            max-width: 100% !important;
                            padding: 0 !important;
                            border: none !important;
                        }


                        /* 3. Paksa Gambar Memenuhi Lebar Kolom */
                        .custom-content img {
                            display: block !important;
                            width: 100% !important; /* Gambar dipaksa selebar kolom teks */
                            max-width: 100% !important;
                            height: auto !important;
                            border-radius: 0.75rem;
                            cursor: zoom-in;
                            margin: 0 !important;
                            transition: opacity 0.3s ease;
                        }

                        .custom-content img:hover {
                            opacity: 0.9; /* Efek halus saat disentuh mouse */
                        }

                        /* 4. Caption Tetap di Tengah Bawah Gambar */
                        .custom-content figcaption {
                            display: block !important;
                            width: 100% !important;
                            text-align: center !important; /* Teks caption di tengah */
                            margin-top: 1rem !important;
                            font-size: 0.9rem !important;
                            color: #6b7280 !important;
                            font-style: italic !important;
                            padding: 0 1rem !important;
                        }
                    </style>

                </article>

                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="flex flex-wrap gap-2">
                        <span class="text-sm font-bold text-gray-400 mr-2 flex items-center">Tags:</span>
                        
                        <a href="{{ route('posts.category', $post->category->slug) }}" class="text-xs bg-gray-100 px-3 py-1 rounded-full text-gray-600 hover:bg-mesuluh-primary hover:text-white transition">
                            #{{ $post->category->name }}
                        </a>

                        @foreach($post->tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}" 
                            class="inline-block px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm hover:bg-primary-50 hover:text-primary-600 transition">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                        
                    </div>
                </div>

                <div class="mt-8 bg-mesuluh-cream/30 p-6 rounded-xl border border-mesuluh-primary/10">
                    
                    <div class="flex items-center justify-center gap-2 text-sm text-gray-500 mb-4 font-sans border-b border-gray-200 pb-4 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-mesuluh-primary"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span class="font-bold text-mesuluh-dark">{{ number_format($post->views) }}</span> 
                        <span>kali dibaca</span>
                    </div>

                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <span class="text-lg font-bold text-mesuluh-dark">Bagikan tulisan ini:</span>
                        
                        <div class="flex items-center gap-3">
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . route('posts.show', $post)) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:opacity-90 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.008-.57-.008-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            </a>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.show', $post) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:opacity-90 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>

                            <a href="https://twitter.com/intent/tweet?url={{ route('posts.show', $post) }}&text={{ $post->title }}" target="_blank" class="w-10 h-10 rounded-full bg-black text-white flex items-center justify-center hover:opacity-90 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z" /><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" /></svg>
                            </a>

                            <div x-data="{ copied: false }">
                                <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)" 
                                        class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-300 transition shadow-sm relative"
                                        title="Salin Link">
                                    
                                    <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                    
                                    <svg x-show="copied" x-cloak xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600"><polyline points="20 6 9 17 4 12"></polyline></svg>

                                    <span x-show="copied" x-cloak class="absolute -top-8 left-1/2 -translate-x-1/2 bg-black text-white text-[10px] py-1 px-2 rounded">Disalin!</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-16 bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6 items-center md:items-start text-center md:text-left">
                    <div class="w-20 h-20 rounded-full bg-mesuluh-cream flex-shrink-0 overflow-hidden border-2 border-mesuluh-primary/20">
                         <svg class="w-full h-full text-mesuluh-primary/40 p-2" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-bold text-gray-900 uppercase tracking-wider text-xs mb-1">Tentang Penulis</h3>
                        <h4 class="font-serif font-bold text-xl text-mesuluh-dark mb-2">{{ $post->user->name }}</h4>
                        <p class="text-sm text-gray-600 leading-relaxed mb-4">
                            Menulis sepenuh hati untuk menyuarakan apa yang acap kali terbungkam di sudut-sudut pulau Dewata. Jurnalis & Kontributor Mesuluh.
                        </p>
                        <a href="{{ route('posts.author', $post->user) }}" class="text-mesuluh-primary text-sm font-bold hover:underline">
                            Lihat Profil Penulis &rarr;
                        </a>
                    </div>
                </div>

            </div>

            <aside class="lg:w-1/3">
                
                <div class="sticky top-28 flex flex-col gap-8">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-6 uppercase tracking-wider text-xs flex items-center gap-2 border-b border-gray-100 pb-2">
                            <span class="w-2 h-2 bg-mesuluh-primary rounded-full"></span>
                            Terbaru dari Redaksi
                        </h3>
                        
                        <div class="space-y-6">
                            @foreach($latestPosts as $latest)
                                <a href="{{ route('posts.show', $latest) }}" class="flex gap-4 group items-start">
                                    <span class="text-2xl font-serif font-bold text-gray-200 group-hover:text-mesuluh-primary transition -mt-1">0{{ $loop->iteration }}</span>
                                    
                                    <div>
                                        <span class="text-[10px] font-bold text-mesuluh-primary uppercase tracking-wider">{{ $latest->category->name }}</span>
                                        <h4 class="font-serif font-bold text-mesuluh-dark leading-snug group-hover:text-mesuluh-primary transition line-clamp-2 mb-1">
                                            {{ $latest->title }}
                                        </h4>
                                        <span class="text-xs text-gray-400 block">{{ $latest->published_at->format('d M Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                            <a href="{{ route('posts.search') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-mesuluh-primary transition">Lihat Indeks</a>
                        </div>
                    </div> 
                    <div class="bg-mesuluh-dark p-8 rounded-2xl text-center text-mesuluh-cream relative overflow-hidden group">
                         <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 bg-mesuluh-primary rounded-full opacity-20 blur-2xl group-hover:opacity-40 transition"></div>
                         
                         <h4 class="font-serif text-xl italic mb-4 relative z-10">"Jadilah Suluh bagi sekitarmu."</h4>
                         
                         <a href="{{ url('/') }}#newsletter" class="inline-block px-6 py-2 border border-mesuluh-cream/30 rounded-full text-xs font-bold hover:bg-mesuluh-cream hover:text-mesuluh-primary transition relative z-10">
                            Berlangganan
                        </a>
                    </div>

                </div>
            </aside>

        </div>
        {{-- Navigasi Next/Prev --}}
        <div class="grid grid-cols-2 gap-4 py-8 border-t border-b border-gray-100 my-10">
            {{-- Sebelumnya --}}
            <div>
                @if($prevPost)
                    <a href="{{ route('posts.show', $prevPost->slug) }}" class="group block">
                        <span class="text-xs text-gray-400 uppercase tracking-widest">Sebelumnya</span>
                        <p class="font-bold text-gray-900 group-hover:text-mesuluh-primary transition line-clamp-1">
                            ← {{ $prevPost->title }}
                        </p>
                    </a>
                @endif
            </div>

            {{-- Selanjutnya --}}
            <div class="text-right">
                @if($nextPost)
                    <a href="{{ route('posts.show', $nextPost->slug) }}" class="group block">
                        <span class="text-xs text-gray-400 uppercase tracking-widest">Selanjutnya</span>
                        <p class="font-bold text-gray-900 group-hover:text-mesuluh-primary transition line-clamp-1">
                            {{ $nextPost->title }} →
                        </p>
                    </a>
                @endif
            </div>
        </div>
    </div>

    

    @if($relatedPosts->count() > 0)
    <section class="bg-gray-50 border-t border-gray-200 py-16">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-serif text-2xl font-bold text-mesuluh-dark">Bacaan Serupa di {{ $post->category->name }}</h3>
                <a href="{{ route('posts.category', $post->category->slug) }}" class="text-sm font-bold text-mesuluh-primary hover:underline">Lihat Semua &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related) }}" class="group block bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden border border-gray-100">
                        <div class="aspect-[4/3] overflow-hidden">
                             <img src="{{ asset('storage/' . $related->thumbnail) }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-4">
                            <span class="text-[10px] font-bold text-mesuluh-primary uppercase tracking-wider">{{ $related->category->name }}</span>
                            <h4 class="font-serif font-bold text-lg text-mesuluh-dark leading-tight mt-1 mb-2 group-hover:text-mesuluh-primary transition">
                                {{ $related->title }}
                            </h4>
                            <p class="text-xs text-gray-500">{{ $related->published_at->format('d M Y') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-layouts.app>