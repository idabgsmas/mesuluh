<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Mesuluh' }} - Merawat Kehidupan</title>

    <meta name="description" content="{{ $description ?? 'Media organik yang membahas kisah perempuan Bali dengan jujur.' }}">
    
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
</head>
<body class="bg-mesuluh-cream text-mesuluh-dark font-sans antialiased">

    <header class="border-b border-mesuluh-primary/10 sticky top-0 z-50 bg-mesuluh-cream/95 backdrop-blur-sm" 
            x-data="{ open: false }"> <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            
            <a href="/" class="font-serif text-3xl font-bold text-mesuluh-primary tracking-wide">
                MESULUH
            </a>

            <nav class="hidden md:flex gap-8 font-medium font-sans text-sm tracking-wide">
                <a href="/" class="hover:text-mesuluh-primary transition {{ request()->is('/') ? 'text-mesuluh-primary font-bold' : 'text-gray-600' }}">Beranda</a>
                <a href="{{ route('posts.category', 'sulur') }}" class="hover:text-mesuluh-primary transition {{ request()->is('kategori/sulur') ? 'text-mesuluh-primary font-bold' : 'text-gray-600' }}">Sulur</a>
                <a href="{{ route('posts.category', 'suluh') }}" class="hover:text-mesuluh-primary transition {{ request()->is('kategori/suluh') ? 'text-mesuluh-primary font-bold' : 'text-gray-600' }}">Suluh</a>
                <a href="{{ route('posts.category', 'singgah') }}" class="hover:text-mesuluh-primary transition {{ request()->is('kategori/singgah') ? 'text-mesuluh-primary font-bold' : 'text-gray-600' }}">Singgah</a>
                <a href="{{ route('posts.category', 'taut') }}" class="hover:text-mesuluh-primary transition {{ request()->is('kategori/taut') ? 'text-mesuluh-primary font-bold' : 'text-gray-600' }}">Taut</a>
                <a href="{{ route('about') }}" class="hover:text-mesuluh-primary transition {{ request()->routeIs('about') ? 'text-mesuluh-primary font-bold' : 'text-gray-600' }}">
                    Tentang Mesuluh
                </a>
            </nav>

            <div class="flex items-center gap-4">
                <form action="{{ route('posts.search') }}" method="GET" class="hidden md:flex items-center bg-white border border-mesuluh-primary/20 rounded-full px-3 py-1 focus-within:ring-2 focus-within:ring-mesuluh-primary/20 transition">
                    <input type="text" name="q" placeholder="Cari..." 
                           class="bg-transparent border-none text-sm w-32 lg:w-48 focus:ring-0 text-mesuluh-dark placeholder-gray-400 font-sans"
                           value="{{ request('q') }}">
                    <button type="submit" class="text-mesuluh-primary hover:text-mesuluh-dark transition p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </form>

                <button @click="open = !open" class="md:hidden text-mesuluh-primary p-2">
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
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-t border-mesuluh-primary/10 absolute w-full shadow-lg">
            
            <div class="flex flex-col p-4 gap-4 font-sans text-lg">
                <form action="{{ route('posts.search') }}" method="GET" class="flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                    <input type="text" name="q" placeholder="Cari tulisan..." class="bg-transparent border-none w-full focus:ring-0 text-sm" value="{{ request('q') }}">
                    <button type="submit" class="text-mesuluh-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    </button>
                </form>

                <a href="/" class="py-2 border-b border-gray-100 hover:text-mesuluh-primary">Beranda</a>
                <a href="{{ route('posts.category', 'sulur') }}" class="py-2 border-b border-gray-100 hover:text-mesuluh-primary">Sulur</a>
                <a href="{{ route('posts.category', 'suluh') }}" class="py-2 border-b border-gray-100 hover:text-mesuluh-primary">Suluh</a>
                <a href="{{ route('posts.category', 'singgah') }}" class="py-2 border-b border-gray-100 hover:text-mesuluh-primary">Singgah</a>
                <a href="{{ route('posts.category', 'taut') }}" class="py-2 hover:text-mesuluh-primary">Taut</a>
                <a href="{{ route('about') }}" class="py-2 hover:text-mesuluh-primary font-bold text-mesuluh-dark/80">
                    Tentang Mesuluh
                </a>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-mesuluh-primary text-mesuluh-cream py-16 mt-20 border-t border-white/10">
        <div class="container mx-auto px-4 text-center">
            
            <h2 class="font-serif text-3xl mb-6 font-bold tracking-wider">Mesuluh</h2>
            
            <div class="flex flex-wrap justify-center gap-6 mb-8 font-sans text-sm tracking-wide font-medium opacity-80">
                <a href="/" class="hover:text-white hover:opacity-100 transition">Beranda</a>
                <a href="{{ route('about') }}" class="hover:text-white hover:opacity-100 transition">Tentang Mesuluh</a>
                <a href="#" class="hover:text-white hover:opacity-100 transition">Redaksi</a> <a href="#" class="hover:text-white hover:opacity-100 transition">Kontak</a>
            </div>

            <p class="font-sans text-sm opacity-60 max-w-md mx-auto mb-8 leading-relaxed">
                Merawat hingga meruwat kehidupan. Media organik yang membahas kisah perempuan Bali dengan jujur.
            </p>

            <div class="h-px w-12 bg-mesuluh-cream/30 mx-auto mb-8"></div>

            <div class="text-xs opacity-40 font-sans">
                &copy; {{ date('Y') }} Mesuluh. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>