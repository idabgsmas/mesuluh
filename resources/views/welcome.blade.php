<x-layouts.app title="Beranda">
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

    <section class="relative z-10 min-h-screen flex flex-col justify-center items-center text-center px-4 bg-mesuluh-cream border-b border-mesuluh-primary/5 overflow-hidden">
        
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-mesuluh-primary/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
            
            <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-200/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-200/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-mesuluh-primary/10 rounded-full blur-3xl animate-pulse"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto space-y-8">
            
            <span class="inline-block py-1 px-3 border border-mesuluh-primary/30 rounded-full text-mesuluh-primary font-bold tracking-[0.2em] uppercase text-xs backdrop-blur-sm bg-white/30">
                Media Organik Perempuan Bali
            </span>
            
            <h1 class="font-serif text-6xl md:text-8xl text-mesuluh-dark leading-none drop-shadow-sm">
                Berkisah sebagai <br> 
                <span class="text-mesuluh-primary italic relative">
                    Suluh Kehidupan
                    <svg class="absolute w-full h-3 -bottom-1 left-0 text-mesuluh-primary/30" viewBox="0 0 200 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.00025 6.99999C18.5002 9.99999 74.5002 14.5 102 3.99999C133 -7.50001 176 11.5 198 2.49999" stroke="currentColor" stroke-width="3"/></svg>
                </span>
            </h1>
            
            <p class="text-lg md:text-2xl text-gray-600 font-sans font-light leading-relaxed max-w-2xl mx-auto">
                Membahas kisah-kisah dari sudut ke sudut, <br class="hidden md:block"> 
                dari desa hingga kota dengan jujur.
            </p>

            <div class="pt-8">
                <a href="#featured" class="inline-block px-8 py-4 bg-mesuluh-primary text-mesuluh-cream font-bold rounded-full hover:bg-mesuluh-dark transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    Mulai Membaca
                </a>
            </div>

        </div>

        <div class="absolute bottom-8 left-0 w-full flex justify-center pb-4 animate-bounce text-mesuluh-primary/50 z-20">
            <div class="flex flex-col items-center">
                <span class="text-[10px] uppercase tracking-widest mb-2">Gulir ke bawah</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                </svg>
            </div>
        </div>

    </section>


    <div id="featured" class="scroll-mt-24">
        
        
        @if($featuredPosts->count() > 0)
        <section class="relative bg-mesuluh-cream" 
                x-data="{ 
                    activeSlide: 0, 
                    totalSlides: {{ $featuredPosts->count() }},
                    next() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides },
                    autoPlay() { setInterval(() => this.next(), 6000) } 
                }" 
                x-init="autoPlay()">
            <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
                {{-- <div class="absolute top-0 -left-4 w-72 h-72 bg-mesuluh-primary/20 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div> --}}
                
                {{-- <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-200/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div> --}}
                
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-200/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-mesuluh-primary/10 rounded-full blur-3xl animate-pulse"></div>
            </div>

            <div class="container mx-auto px-4 py-12 relative min-h-[600px] md:min-h-[500px] flex items-center">
                
                @foreach($featuredPosts as $index => $featured)
                <div x-show="activeSlide === {{ $index }}"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-x-10"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-300 absolute"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-10"
                    class="w-full flex flex-col lg:flex-row gap-12 items-center inset-0">

                    <div class="lg:w-1/2 order-2 lg:order-1 space-y-6 z-10">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 border border-mesuluh-primary text-mesuluh-primary text-xs font-bold tracking-widest uppercase rounded-full">
                                {{ $featured->category->name }}
                            </span>
                            <span class="text-gray-500 text-sm font-sans">
                                {{ $featured->published_at->format('d F Y') }}
                            </span>
                        </div>

                        <a href="{{ route('posts.show', $featured) }}" class="block group">
                            <h1 class="font-serif text-4xl lg:text-6xl text-mesuluh-dark leading-[1.1] group-hover:text-mesuluh-primary transition duration-300">
                                {{ $featured->title }}
                            </h1>
                        </a>

                        <p class="font-sans text-gray-600 text-lg leading-relaxed line-clamp-3">
                            {{ $featured->excerpt }}
                        </p>

                        <div class="flex items-center gap-3 pt-4">
                            @if($featured->user->avatar)
                                <img src="{{ asset('storage/' . $featured->user->avatar) }}" class="w-10 h-10 rounded-full object-cover border border-mesuluh-primary/20">
                            @else
                                <div class="w-10 h-10 rounded-full bg-mesuluh-primary text-white flex items-center justify-center font-bold font-serif">
                                    {{ substr($featured->user->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="text-sm">
                                <p class="font-bold text-mesuluh-dark">{{ $featured->user->name }}</p>
                                <p class="text-gray-500">Penulis</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:w-1/2 order-1 lg:order-2 w-full">
                        <a href="{{ route('posts.show', $featured) }}" class="block overflow-hidden rounded-2xl shadow-xl aspect-[4/3] group relative">
                            <div class="absolute inset-0 bg-mesuluh-primary/0 group-hover:bg-mesuluh-primary/10 transition z-10 duration-500"></div>
                            <img src="{{ asset('storage/' . $featured->thumbnail) }}" 
                                alt="{{ $featured->title }}" 
                                class="w-full h-full object-cover">
                        </a>
                    </div>

                </div>
                @endforeach

            </div>

            <div class="container mx-auto px-4 relative -mt-10 lg:mt-0 z-20 pb-8 flex justify-between lg:justify-start lg:gap-4">
                <button @click="prev()" class="w-12 h-12 rounded-full border border-mesuluh-dark/20 flex items-center justify-center hover:bg-mesuluh-primary hover:border-mesuluh-primary hover:text-white transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>
                
                <button @click="next()" class="w-12 h-12 rounded-full border border-mesuluh-dark/20 flex items-center justify-center hover:bg-mesuluh-primary hover:border-mesuluh-primary hover:text-white transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </button>

                <div class="hidden lg:flex items-center gap-2 ml-8">
                    @foreach($featuredPosts as $index => $featured)
                        <button @click="activeSlide = {{ $index }}" 
                                :class="activeSlide === {{ $index }} ? 'w-8 bg-mesuluh-primary' : 'w-2 bg-mesuluh-dark/20'"
                                class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            </div>

        </section>
        @else
        <section class="container mx-auto px-4 py-20 text-center">
            <h1 class="font-serif text-5xl text-mesuluh-dark mb-4">Mesuluh</h1>
            <p class="text-gray-500">Belum ada tulisan utama yang dipilih.</p>
        </section>
        @endif
    </div>

    <div class="container mx-auto px-4">
        <div class="border-t border-mesuluh-primary/20"></div>
    </div>

    <section class="container mx-auto px-4 py-16">
        
        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="lg:w-2/3">
                
                <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
                    <h2 class="font-serif text-3xl text-mesuluh-dark">
                        Terbaru dari Redaksi
                    </h2>
                    <a href="#" class="text-xs font-bold tracking-widest uppercase text-mesuluh-primary hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                    @foreach($latestPosts as $post)
                        <article class="flex flex-col group">
                            <a href="{{ route('posts.show', $post) }}" class="block overflow-hidden rounded-xl mb-4 relative aspect-[3/2]">
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500 grayscale-[20%] group-hover:grayscale-0">
                                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-mesuluh-dark rounded-md shadow-sm">
                                    {{ $post->category->name }}
                                </span>
                            </a>

                            <div class="flex flex-col flex-grow">
                                <div class="text-xs text-gray-400 mb-2 font-sans flex items-center gap-2">
                                    <span class="text-mesuluh-primary">{{ $post->user->name }}</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>{{ $post->published_at->format('d M Y') }}</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                    <span>{{ $post->views }} x dibaca</span>
                                </div>
                                
                                <a href="{{ route('posts.show', $post) }}">
                                    <h3 class="font-serif text-xl font-bold text-mesuluh-dark leading-tight mb-2 group-hover:text-mesuluh-primary transition">
                                        {{ $post->title }}
                                    </h3>
                                </a>

                                <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed mb-3">
                                    {{ $post->excerpt }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>

            <div class="lg:w-1/3">
                
                <div class="sticky top-24">
                    
                    <div class="bg-mesuluh-cream/50 p-6 rounded-2xl border border-mesuluh-primary/10">
                        <h3 class="font-serif text-2xl text-mesuluh-primary mb-6 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.307a11.95 11.95 0 0 1 5.814-5.519l2.74-1.22m0 0-5.94-2.28m5.94 2.28-4.277 4.277" />
                            </svg>
                            Paling Banyak Dibaca
                        </h3>

                        <div class="space-y-6">
                            @foreach($popularPosts as $index => $pop)
                                <div class="flex gap-4 items-start group">
                                    <span class="text-4xl font-serif font-bold text-mesuluh-primary/20 group-hover:text-mesuluh-primary/40 transition -mt-2">
                                        {{ $index + 1 }}
                                    </span>
                                    
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">
                                            {{ $pop->category->name }}
                                        </div>
                                        <a href="{{ route('posts.show', $pop) }}">
                                            <h4 class="font-bold text-mesuluh-dark leading-snug group-hover:text-mesuluh-primary transition">
                                                {{ $pop->title }}
                                            </h4>
                                        </a>
                                        <span class="text-xs text-gray-500 mt-1 block">{{ $pop->user->name }} | {{ $pop->published_at->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-500 mt-1 block">{{ $pop->views }} Pembaca</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 p-6 bg-mesuluh-dark text-mesuluh-cream rounded-xl text-center relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-4 -mt-4 w-20 h-20 bg-mesuluh-primary rounded-full opacity-20 blur-xl"></div>
                        <p class="font-serif text-lg italic relative z-10">
                            "Perempuan adalah penyangga kehidupan yang tak pernah lelah memberi cahaya."
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="container mx-auto px-4 py-8">
        <div class="bg-mesuluh-dark rounded-3xl p-10 md:p-16 relative overflow-hidden text-center group">
            
            <div class="absolute top-0 left-0 w-64 h-64 bg-mesuluh-primary opacity-20 rounded-full blur-3xl transform -translate-x-1/2 -translate-y-1/2 group-hover:opacity-30 transition duration-1000"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-mesuluh-primary opacity-20 rounded-full blur-3xl transform translate-x-1/2 translate-y-1/2 group-hover:opacity-30 transition duration-1000"></div>

            <div class="text-mesuluh-primary opacity-20 text-9xl font-serif absolute top-4 left-8 leading-none select-none">“</div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <p class="font-serif text-2xl md:text-4xl text-mesuluh-cream leading-relaxed italic mb-8">
                    "Perempuan Bali adalah penopang adat yang tangguh, namun ia juga sungai yang mengalirkan kelembutan bagi peradaban."
                </p>
                
                <div class="flex flex-col items-center">
                    <div class="h-1 w-12 bg-mesuluh-primary mb-4"></div>
                    <span class="text-white font-bold tracking-widest uppercase text-sm">Redaksi Mesuluh</span>
                </div>
            </div>

        </div>
    </section>

    @if($rubrics->count() > 0)
    <section class="bg-mesuluh-primary text-mesuluh-cream py-20" 
             x-data="{ activeTab: {{ $rubrics->first()->id }} }"> <div class="container mx-auto px-4">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                
                <div>
                    <span class="text-xs font-bold tracking-widest uppercase opacity-60">Kekayaan Arsip</span>
                    <h2 class="font-serif text-4xl mt-2">Jelajah Rubrik</h2>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach($rubrics as $category)
                        <button @click="activeTab = {{ $category->id }}"
                                :class="activeTab === {{ $category->id }} 
                                    ? 'bg-mesuluh-cream text-mesuluh-primary shadow-lg scale-105' 
                                    : 'bg-transparent border border-mesuluh-cream/30 text-mesuluh-cream hover:bg-mesuluh-cream/10'"
                                class="px-6 py-2 rounded-full text-sm font-bold transition-all duration-300 transform">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

            </div>

            <div class="relative min-h-[400px]">
                @foreach($rubrics as $category)
                    <div x-show="activeTab === {{ $category->id }}"
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="flex flex-col gap-10"> <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($category->posts as $post)
                                <a href="{{ route('posts.show', $post) }}" class="group block bg-mesuluh-cream rounded-xl p-3 border border-white/5 hover:bg-white/10 transition duration-300">
                                    <div class="aspect-[4/3] overflow-hidden rounded-lg mb-4 relative">
                                         <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 opacity-90 group-hover:opacity-100">
                                         <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                                    </div>
                                    
                                    <h3 class="font-serif text-lg leading-snug mb-2 group-hover:text-mesuluh-cream text-mesuluh-primary">
                                        {{ $post->title }}
                                    </h3>
                                    
                                    <div class="flex justify-between items-center mt-3 pt-3 border-t border-black/10">
                                        {{-- <span class="text-xs opacity-60 font-sans">{{ $post->user->name }}</span> --}}
                                        {{-- <span class="w-1 h-1 bg-gray-300 rounded-full"></span> --}}
                                        <span class="text-xs opacity-60 font-sans group-hover:text-mesuluh-cream text-black/90">{{ $post->published_at->format('d M Y') }}</span>
                                        <span class="text-xs font-bold text-mesuluh-cream opacity-0 group-hover:opacity-100 transition transform translate-x-2 group-hover:translate-x-0">
                                            Baca &rarr;
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="flex justify-center mt-8">
                            <a href="{{ route('posts.category', $category->slug) }}" 
                               class="group flex flex-row-reverse items-center gap-4 text-mesuluh-cream opacity-80 hover:opacity-100 transition">
                                
                                <div class="w-12 h-12 rounded-full border border-mesuluh-cream/30 flex items-center justify-center group-hover:bg-mesuluh-cream group-hover:text-mesuluh-primary transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </div>

                                <span class="font-serif text-sm tracking-wider uppercase font-bold group-hover:underline underline-offset-4 decoration-1">
                                    Lihat Semua {{ $category->name }}
                                </span>

                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>
    @endif

    {{-- <section class="bg-mesuluh-primary text-mesuluh-cream py-16 mt-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="font-serif text-3xl md:text-4xl mb-4">Ingin kabar terbaru?</h2>
            <p class="opacity-80 max-w-lg mx-auto mb-8 font-sans">
                Dapatkan cerita-cerita pilihan langsung ke kotak masuk surel Anda setiap minggunya.
            </p>
            <form class="flex flex-col sm:flex-row gap-3 justify-center max-w-md mx-auto">
                <input type="email" placeholder="Alamat Surel Anda" class="px-4 py-3 rounded-lg text-mesuluh-dark focus:ring-2 focus:ring-mesuluh-cream border-none w-full">
                <button type="button" class="px-6 py-3 bg-mesuluh-dark text-white font-bold rounded-lg hover:bg-opacity-80 transition">
                    Berlangganan
                </button>
            </form>
        </div>
    </section> --}}

    <section id="newsletter" class="border-t border-mesuluh-primary/10 bg-white scroll-mt-20">
        <div class="container mx-auto px-4 py-20 text-center">
            
            <span class="inline-block p-3 rounded-full bg-mesuluh-primary/5 text-mesuluh-primary mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
            </span>

            <h2 class="font-serif text-3xl md:text-4xl text-mesuluh-dark mb-4">
                Jangan Lewatkan Kisah Terbaru
            </h2>
            
            <p class="text-gray-500 max-w-lg mx-auto mb-8 font-sans">
                Bergabunglah dengan komunitas kami. Dapatkan kurasi tulisan pilihan yang dikirim langsung ke surel Anda setiap pekannya.
            </p>

            <div class="max-w-md mx-auto mb-6">
                @if(session('success'))
                    <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm font-bold border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @error('email')
                    <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm font-bold border border-red-200">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <form action="{{ route('subscribe.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 justify-center max-w-md mx-auto relative">
                @csrf <input type="email" name="email" placeholder="Alamat Surel Anda..." required
                       class="px-5 py-3 rounded-full bg-gray-50 border border-gray-200 text-mesuluh-dark focus:ring-2 focus:ring-mesuluh-primary focus:border-mesuluh-primary w-full transition outline-none">
                
                <button type="submit" class="px-8 py-3 bg-mesuluh-primary text-mesuluh-cream font-bold rounded-full hover:bg-mesuluh-dark hover:-translate-y-1 transition shadow-lg whitespace-nowrap">
                    Berlangganan
                </button>
            </form>

            <p class="text-xs text-gray-400 mt-6">
                Kami menghargai privasi Anda. Bebas berhenti berlangganan kapan saja.
            </p>

        </div>
    </section>

</x-layouts.app>