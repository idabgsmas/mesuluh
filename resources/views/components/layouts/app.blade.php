<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- SEO DINAMIS --}}
    @hasSection('seo')
        @yield('seo')
    @else
        <title>{{ $title ?? 'Mesuluh' }} - Merawat Kehidupan</title>
        <meta name="description" content="{{ $description ?? 'Media organik yang membahas kisah perempuan Bali dengan jujur.' }}">
    @endif
    
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'Mesuluh' }} - Merawat Kehidupan">
    <meta property="og:description" content="{{ $description ?? 'Media organik yang membahas kisah perempuan Bali dengan jujur.' }}">
    <meta property="og:image" content="{{ $image ?? asset('images/default-share.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Mesuluh' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Media organik yang membahas kisah perempuan Bali dengan jujur.' }}">
    <meta name="twitter:image" content="{{ $image ?? asset('images/default-share.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Suranna&display=swap" rel="stylesheet">
    {{-- *Penjelasan:* Kode di atas menggunakan variabel `$description` dan `$image`. Jika halaman tersebut tidak mengirim data (misal halaman Beranda), dia akan pakai teks default. --}}
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-mesuluh-cream text-mesuluh-dark font-sans antialiased">

    <header class="fixed top-0 w-full z-50 transition-all duration-300" 
            x-data="{ open: false, scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="scrolled 
                ? 'bg-mesuluh-primary/90 backdrop-blur-md shadow-md py-4' 
                : 'bg-mesuluh-cream/95 backdrop-blur-sm border-b border-mesuluh-primary/10 py-6'">
        
        <div class="container mx-auto px-4 flex items-center justify-between transition-all duration-300">
            
            {{-- <a href="/" 
               class="font-serif text-3xl font-bold tracking-wide transition-colors duration-300"
               :class="scrolled ? 'text-mesuluh-cream' : 'text-mesuluh-primary'">
                MESULUH
            </a> --}}

        <div class="container mx-auto px-4 flex items-center justify-between transition-all duration-300">
            {{-- Link Logo & Nama Brand --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                {{-- Tag Logo --}}
                <img src="{{ asset('images/logo-mesuluh.png') }}" 
                    alt="Logo Mesuluh" 
                    class="h-12 w-auto object-contain"
                    :class="scrolled ? 'filter brightness-0 invert' : ''">
                
                {{-- Teks Brand (Tetap Ada) --}}
                <span class="font-serif text-3xl font-bold tracking-wide transition-colors duration-300"
               :class="scrolled ? 'text-mesuluh-cream' : 'text-mesuluh-primary'">
                    MESULUH
                </span>
            </a>
            

            <nav class="hidden md:flex gap-8 font-medium font-sans text-sm tracking-wide transition-colors duration-300">
                @foreach([
                    ['url' => '/', 'label' => 'Beranda'],
                    ['url' => route('posts.category', 'sulur'), 'label' => 'Sulur'],
                    ['url' => route('posts.category', 'suluh'), 'label' => 'Suluh'],
                    ['url' => route('posts.category', 'singgah'), 'label' => 'Singgah'],
                    ['url' => route('posts.category', 'taut'), 'label' => 'Taut'],
                    ['url' => route('about'), 'label' => 'Tentang Mesuluh']
                ] as $link)
                    <a href="{{ $link['url'] }}" 
                       class="transition-colors duration-300 hover:underline underline-offset-4 decoration-2"
                       :class="scrolled 
                            ? 'text-mesuluh-cream/90 hover:text-white decoration-mesuluh-cream' 
                            : '{{ request()->fullUrlIs($link['url']) ? 'text-mesuluh-primary font-bold' : 'text-gray-600' }} hover:text-mesuluh-primary decoration-mesuluh-primary'">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- <div class="flex items-center gap-2 text-xs font-bold ml-4">
                <a href="{{ route('switch.language', 'id') }}" 
                class="{{ app()->getLocale() == 'id' ? 'text-mesuluh-primary underline' : 'text-gray-400 hover:text-mesuluh-primary' }}">
                ID
                </a>
                <span class="text-gray-300">|</span>
                <a href="{{ route('switch.language', 'en') }}" 
                class="{{ app()->getLocale() == 'en' ? 'text-mesuluh-primary underline' : 'text-gray-400 hover:text-mesuluh-primary' }}">
                EN
                </a>
            </div> --}}

                <form action="{{ route('posts.search') }}" method="GET" 
                      class="hidden md:flex items-center rounded-full px-3 py-1 transition-all duration-300"
                      :class="scrolled ? 'bg-white/10 border border-white/20 text-white focus-within:bg-white focus-within:text-mesuluh-dark' : 'bg-white border border-mesuluh-primary/20 text-mesuluh-dark'">
                    
                    <input type="text" name="q" placeholder="Cari..." 
                           class="bg-transparent border-none text-sm w-32 lg:w-48 focus:ring-0 placeholder-current font-sans transition-colors"
                           :class="scrolled ? 'placeholder-white/60 focus:placeholder-gray-400' : 'placeholder-gray-400'"
                           value="{{ request('q') }}">
                    
                    <button type="submit" class="p-1 transition-colors"
                            :class="scrolled ? 'text-white hover:text-mesuluh-cream' : 'text-mesuluh-primary hover:text-mesuluh-dark'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>

                <button @click="open = !open" class="md:hidden p-2 transition-colors"
                        :class="scrolled ? 'text-mesuluh-cream' : 'text-mesuluh-primary'">
                    <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" 
             x-cloak
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-t border-mesuluh-primary/10 absolute w-full shadow-xl">
            
            <div class="flex flex-col p-4 gap-4 font-sans text-lg text-gray-700">
                <form action="{{ route('posts.search') }}" method="GET" class="flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 mb-2">
                    <input type="text" name="q" placeholder="Cari tulisan..." class="bg-transparent border-none w-full focus:ring-0 text-sm placeholder-gray-400 text-mesuluh-dark" value="{{ request('q') }}">
                    <button type="submit" class="text-mesuluh-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    </button>
                </form>

                @foreach([
                    ['url' => '/', 'label' => 'Beranda'],
                    ['url' => route('posts.category', 'sulur'), 'label' => 'Sulur'],
                    ['url' => route('posts.category', 'suluh'), 'label' => 'Suluh'],
                    ['url' => route('posts.category', 'singgah'), 'label' => 'Singgah'],
                    ['url' => route('posts.category', 'taut'), 'label' => 'Taut'],
                    ['url' => route('about'), 'label' => 'Tentang Kami']
                ] as $link)
                    <a href="{{ $link['url'] }}" 
                       class="py-2 border-b border-gray-100 transition duration-200 {{ request()->fullUrlIs($link['url']) ? 'text-mesuluh-primary font-bold pl-2 border-l-4 border-l-mesuluh-primary bg-mesuluh-primary/5' : 'hover:text-mesuluh-primary hover:pl-2' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-mesuluh-primary text-mesuluh-cream mt-20 border-t border-white/10">
        <div class="container mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                
                {{-- Kolom Pertama: Logo + Deskripsi --}}
                <div class="md:col-span-5 flex items-stretch gap-8"> {{-- Ganti items-start menjadi items-stretch, gap diperbesar sedikit --}}
    
                    {{-- Logo Mesuluh --}}
                    <img src="{{ asset('images/logo-mesuluh-white.png') }}" 
                        alt="Logo Mesuluh" 
                        class="h-full w-32 md:w-40 object-contain shrink-0"> {{-- h-full supaya mengikuti tinggi teks, object-contain supaya tidak gepeng --}}

                    {{-- Kontainer Teks & Sosmed --}}
                    <div class="flex flex-col justify-between py-1"> {{-- justify-between supaya teks tersebar merata jika logo sangat tinggi --}}
                        <div class="space-y-4">
                            <a href="/" class="inline-block">
                                <h2 class="font-serif text-4xl md:text-5xl font-bold tracking-wide">MESULUH</h2>
                            </a>
                            <p class="font-sans text-sm md:text-base opacity-80 leading-relaxed max-w-sm">
                                Merawat hingga meruwat kehidupan. Media organik yang membahas kisah-kisah perempuan Bali dari sudut ke sudut dengan jujur dan mendalam.
                            </p>
                        </div>
                        
                        <div class="flex gap-4 pt-6">
                            <a href="#" class="w-10 h-10 rounded-full border border-mesuluh-cream/30 flex items-center justify-center hover:bg-mesuluh-cream hover:text-mesuluh-primary transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full border border-mesuluh-cream/30 flex items-center justify-center hover:bg-mesuluh-cream hover:text-mesuluh-primary transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full border border-mesuluh-cream/30 flex items-center justify-center hover:bg-mesuluh-cream hover:text-mesuluh-primary transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Kolom Rubrikasi --}}
                <div class="md:col-span-3 md:pl-8 border-l border-white/10 md:border-none pl-0">
                    <h3 class="font-serif text-lg font-bold mb-6 text-mesuluh-cream/90 tracking-wider uppercase text-xs">Rubrikasi</h3>
                    <ul class="space-y-3 font-sans text-sm opacity-80">
                        <li><a href="{{ route('posts.category', 'sulur') }}" class="hover:text-white hover:opacity-100 transition inline-block hover:translate-x-1 duration-200">Sulur</a></li>
                        <li><a href="{{ route('posts.category', 'suluh') }}" class="hover:text-white hover:opacity-100 transition inline-block hover:translate-x-1 duration-200">Suluh</a></li>
                        <li><a href="{{ route('posts.category', 'singgah') }}" class="hover:text-white hover:opacity-100 transition inline-block hover:translate-x-1 duration-200">Singgah</a></li>
                        <li><a href="{{ route('posts.category', 'taut') }}" class="hover:text-white hover:opacity-100 transition inline-block hover:translate-x-1 duration-200">Taut</a></li>
                    </ul>
                </div>

                {{-- Kolom Tentang --}}
                <div class="md:col-span-4">
                    <h3 class="font-serif text-lg font-bold mb-6 text-mesuluh-cream/90 tracking-wider uppercase text-xs">Tentang Mesuluh</h3>
                    <ul class="grid grid-cols-2 gap-3 font-sans text-sm opacity-80">
                        <li><a href="{{ route('about') }}" class="hover:text-white hover:opacity-100 transition">Profil Mesuluh</a></li>
                        <li><a href="{{ route('authors.index') }}" class="hover:text-white hover:opacity-100 transition">Tim Redaksi</a></li>
                        <li><a href="{{ route('pedoman') }}" class="hover:text-white hover:opacity-100 transition">Pedoman Media Siber</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white hover:opacity-100 transition">Kontak & Kerjasama</a></li>
                    </ul>

                    <div class="mt-8 p-4 bg-white/5 rounded-lg border border-white/5">
                        <p class="text-xs opacity-60 mb-1">Ada ide tulisan atau kolaborasi?</p>
                        <a href="mailto:redaksi@mesuluh.com" class="text-sm font-bold hover:underline">redaksi@mesuluh.com</a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/10 bg-black/10">
            <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row justify-between items-center text-xs opacity-50 font-sans">
                <p>&copy; {{ date('Y') }} Mesuluh. All rights reserved.</p>
                <div class="flex gap-4 mt-2 md:mt-0">
                    <a href="#" class="hover:opacity-100">Privacy Policy</a>
                    <span>&bull;</span>
                    <a href="#" class="hover:opacity-100">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <div x-data="{ showBackToTop: false }" 
         @scroll.window="showBackToTop = (window.pageYOffset > 300)"
         class="fixed bottom-8 right-8 z-50">
        
        <button @click="window.scrollTo({top: 0, behavior: 'smooth'})"
                x-show="showBackToTop"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-10 scale-90"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-10 scale-90"
                class="bg-mesuluh-primary text-mesuluh-cream w-12 h-12 rounded-full shadow-xl flex items-center justify-center hover:bg-mesuluh-dark hover:-translate-y-1 transition transform border border-white/20">
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
            </svg>

        </button>
    </div>

</body>
</html>