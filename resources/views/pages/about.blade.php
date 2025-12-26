<x-layouts.app 
    title="Tentang Kami" 
    description="Mengenal Mesuluh, media organik yang merawat ingatan dan kehidupan."
>

    <section class="relative py-40 md:py-40 bg-mesuluh-cream overflow-hidden">
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-br from-mesuluh-primary/30 to-purple-500/30 blur-3xl opacity-50 animate-blob animation-delay-2000 filter mix-blend-multiply"></div>
            
            <div class="absolute -bottom-[20%] -left-[10%] w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-red-400/30 to-mesuluh-primary/30 blur-3xl opacity-40 animate-blob animation-delay-4000 filter mix-blend-multiply"></div>

            <div class="absolute bottom-0 left-1/3 w-[400px] h-[400px] rounded-full bg-gradient-to-t from-mesuluh-primary/20 to-pink-400/20 blur-3xl opacity-30 animate-blob filter mix-blend-multiply"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <span class="text-mesuluh-primary font-bold tracking-widest uppercase text-xs mb-4 inline-block bg-mesuluh-primary/5 px-3 py-1 rounded-full">Tentang Kami</span>
            <h1 class="font-serif text-5xl md:text-7xl font-bold text-mesuluh-dark mb-8 tracking-tight">
                Mesuluh
            </h1>
            <div class="max-w-3xl mx-auto">
                <p class="font-serif text-xl md:text-3xl text-gray-700 leading-relaxed italic font-medium">
                    "Dalam bahasa Bali, <span class="text-mesuluh-primary">'Mesuluh'</span> bermakna bercermin. Kami hadir sebagai cermin jernih bagi perempuan Bali untuk melihat kekuatan, kelembutan, dan peran besarnya dalam peradaban."
                </p>
                <div class="flex items-center justify-center gap-2 mt-10 opacity-50">
                    <div class="h-px w-16 bg-mesuluh-primary"></div>
                    <div class="w-2 h-2 rounded-full bg-mesuluh-primary"></div>
                    <div class="h-px w-16 bg-mesuluh-primary"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white relative overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                
                {{-- <div class="relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl bg-white border border-gray-100 flex items-center justify-center p-8 group">
    
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-mesuluh-primary/10 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-orange-400/10 rounded-full blur-2xl"></div>

                    <img src="{{ asset('img/logo.svg') }}" 
                        alt="Logo Mesuluh" 
                        class="w-full max-w-[500px] h-auto object-contain relative z-10 transform group-hover:scale-110 transition duration-700 drop-shadow-sm">

                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
                </div> --}}

                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-72 h-72 bg-gradient-to-br from-mesuluh-primary/30 to-purple-500/30 rounded-full blur-2xl animate-blob opacity-70 mix-blend-multiply"></div>
                    <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-gradient-to-tl from-red-400/30 to-mesuluh-primary/30 rounded-full blur-2xl animate-blob opacity-70 mix-blend-multiply" style="animation-delay: 2s"></div>

                    <div class="relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl bg-gray-100 border border-gray-100">
                        <img src="https://haluanindonesia.co.id/wp-content/uploads/2023/08/IMG-20230825-WA0029.jpg" 
                        {{-- <img src="{{ asset('images/logo-mesuluh.png') }}"  --}}
                             alt="Perempuan Bali" class="w-full h-full object-cover hover:scale-105 transition duration-700">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                </div>

                <div class="space-y-6">
                    {{-- <h2 class="font-serif text-4xl font-bold text-mesuluh-dark">Merawat Ingatan,<br>Meruwat Kehidupan.</h2> --}}
                    <h1 class="font-serif text-4xl md:text-6xl text-mesuluh-dark mb-6">
                        Merawat Ingatan, <br> <span class="text-mesuluh-primary italic">Meruwat Kehidupan.</span>
                    </h1>
                    <div class="h-1 w-24 bg-mesuluh-primary/30 rounded-full"></div>

                    <p class="text-gray-600 leading-loose font-sans">
                        Mesuluh lahir dari kegelisahan sederhana: di tengah riuh pariwisata dan modernitas, suara perempuan Bali seringkali hanya menjadi latar belakang. Padahal, merekalah penopang adat yang paling tangguh.
                    </p>
                    <p class="text-gray-600 leading-loose font-sans">
                        Kami bukan sekadar portal berita. Kami adalah ruang aman untuk bertutur dengan membahas kisah-kisah 
                        Perempuan Bali dari sudut ke sudut, dari desa hingga kota dengan jujur.
                        Mulai dari kisah Sulur (akar tradisi), Suluh (sosok inspiratif), Singgah (tempat-tempat bermakna), hingga Taut (menautkan rasa dan solidaritas).
                    </p>

                    <p class="text-gray-600 leading-loose font-sans">
                        Melalui Kisah Perempuan, kita sebenarnya sedang membicarakan tentang nilai yang lebih luas 
                        yakni menyuarakan suara minoritas, mendukung inklusivitas, dan kehidupan bersama yang lebih 
                        baik dan berkeadilan.
                    </p>

                    {{-- <p class="text-gray-600 leading-loose font-sans">
                        Jurnalisme kami adalah jurnalisme rasa. Kami tidak mengejar kecepatan (clickbait), melainkan kedalaman dan kejujuran rasa.
                    </p> --}}

                    <blockquote class="border-l-4 border-mesuluh-primary pl-4 italic text-mesuluh-primary font-sans">
                        <i>"Sebab kami percaya dengan berkisah mampu menjadi suluh dalam merawat hingga meruwat kehidupan."</i>
                    </blockquote>
                </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-mesuluh-cream">
        <div class="container mx-auto px-4">
            
            <div class="text-center mb-16 max-w-2xl mx-auto">
                <span class="text-mesuluh-primary font-bold tracking-widest uppercase text-xs mb-3 block">Kanal Tulisan</span>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-mesuluh-dark mb-6">Empat Pilar Mesuluh</h2>
                <p class="text-gray-600 font-sans leading-relaxed">
                    Kami membagi narasi menjadi empat ruang tumbuh. Masing-masing memiliki nyawa dan tujuannya sendiri dalam merawat ingatan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-15 group-hover:opacity-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-mesuluh-primary" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-mesuluh-primary mb-2">Sulur</h3>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Akar Tradisi</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Menggali kembali akar tradisi, ritual, dan budaya Bali yang jarang terungkap, merambat layaknya sulur yang menguatkan pohon peradaban.
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-15 group-hover:opacity-50 transition">
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-mesuluh-primary" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7M9 21a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-1H9v1z"/></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-mesuluh-primary mb-2">Suluh</h3>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Sosok Inspiratif</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Kisah-kisah puan yang menjadi penerang. Profil tokoh perempuan Bali yang mendedikasikan hidupnya untuk lingkungan dan sesama.
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-15 group-hover:opacity-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-mesuluh-primary" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-mesuluh-primary mb-2">Singgah</h3>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Ruang & Perjalanan</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Catatan perjalanan ke tempat-tempat yang menyimpan memori kolektif. Menemukan makna di setiap persinggahan.
                    </p>
                </div>

                <div class="group bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-15 group-hover:opacity-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-mesuluh-primary" viewBox="0 0 24 24" fill="currentColor"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                    </div>
                    <h3 class="font-serif text-2xl font-bold text-mesuluh-primary mb-2">Taut</h3>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Opini & Solidaritas</p>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Tulisan opini dan esai reflektif yang menautkan rasa, membangun solidaritas, serta menyuarakan keberpihakan pada yang sunyi.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <section id="redaksi" class="py-24 bg-white relative scroll-mt-32 transition-colors duration-300">
        
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-[0]">
            <svg class="relative block w-[calc(100%+1.3px)] h-[50px] md:h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-mesuluh-cream"></path>
            </svg>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="text-mesuluh-primary font-bold tracking-widest uppercase text-xs mb-3 block">Di Balik Layar</span>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-mesuluh-dark mb-6">Dapur Redaksi</h2>
                <div class="w-24 h-1 bg-mesuluh-primary mx-auto rounded-full mb-6"></div>
                <p class="text-gray-500 max-w-lg mx-auto font-sans">
                    Orang-orang yang bekerja sepenuh hati merawat kata dan rasa untuk menghadirkan tulisan terbaik ke hadapan Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                
                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-mesuluh-cream shadow-lg relative group-hover:scale-110 transition duration-500">
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20">
                              <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark group-hover:text-mesuluh-primary transition">Ida Ayu</h3>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-2">Pemimpin Redaksi</p>
                </div>

                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-mesuluh-cream shadow-lg relative group-hover:scale-110 transition duration-500">
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20">
                              <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark group-hover:text-mesuluh-primary transition">Ni Luh Putu</h3>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-2">Redaktur Pelaksana</p>
                </div>

                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-mesuluh-cream shadow-lg relative group-hover:scale-110 transition duration-500">
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20">
                              <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark group-hover:text-mesuluh-primary transition">Wayan Sari</h3>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-2">Jurnalis</p>
                </div>

                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-mesuluh-cream shadow-lg relative group-hover:scale-110 transition duration-500">
                         <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-20 h-20">
                              <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark group-hover:text-mesuluh-primary transition">Kadek Adi</h3>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mt-2">Editor</p>
                </div>

            </div>
        </div>
    </section>

    <section class="py-20 bg-mesuluh-dark text-mesuluh-cream text-center">
        <div class="container mx-auto px-4">
            <h2 class="font-serif text-3xl font-bold mb-6">Ingin Berkolaborasi?</h2>
            <p class="text-white/60 max-w-xl mx-auto mb-8">
                Kami selalu terbuka untuk ide, kritik, saran, atau sekadar sapaan hangat. Mari bertumbuh bersama.
            </p>
            <a href="{{ route('contact') }}" class="inline-block px-8 py-3 bg-mesuluh-primary text-white font-bold rounded-full hover:bg-white hover:text-mesuluh-dark transition shadow-lg border border-mesuluh-primary">
                Hubungi Kami
            </a>
        </div>
    </section>

</x-layouts.app>