<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Mesuluh' }} - Merawat Kehidupan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Suranna&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-mesuluh-cream text-mesuluh-dark font-sans antialiased">

    <header class="border-b border-mesuluh-primary/10 sticky top-0 z-50 bg-mesuluh-cream/95 backdrop-blur-sm">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            <a href="/" class="font-serif text-3xl font-bold text-mesuluh-primary tracking-wide">
                MESULUH
            </a>

            <nav class="hidden md:flex gap-8 font-medium">
                <a href="#" class="hover:text-mesuluh-primary transition">Beranda</a>
                <a href="#" class="hover:text-mesuluh-primary transition">Sulur</a>
                <a href="#" class="hover:text-mesuluh-primary transition">Suluh</a>
                <a href="#" class="hover:text-mesuluh-primary transition">Singgah</a>
                <a href="#" class="hover:text-mesuluh-primary transition">Taut</a>
            </nav>

            <button class="md:hidden text-mesuluh-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
    </header>

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <footer class="bg-mesuluh-primary text-mesuluh-cream py-12 mt-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="font-serif text-2xl mb-4">Mesuluh</h2>
            <p class="font-sans text-sm opacity-80 max-w-md mx-auto mb-8">
                Merawat hingga meruwat kehidupan. Media organik yang membahas kisah perempuan Bali dengan jujur.
            </p>
            <div class="text-xs opacity-60">
                &copy; {{ date('Y') }} Mesuluh. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>