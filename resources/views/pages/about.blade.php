<x-layouts.app>

    <section class="relative py-24 md:py-40 bg-mesuluh-cream overflow-hidden">
        
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

                    <blockquote>
                        "Sebab kami percaya dengan berkisah mampu menjadi suluh dalam merawat hingga meruwat kehidupan."
                    </blockquote>
                </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-mesuluh-cream/30 border-t border-mesuluh-primary/5">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-mesuluh-dark mb-4">Dapur Redaksi</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Orang-orang yang bekerja di balik layar untuk menghadirkan tulisan terbaik ke hadapan Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-white shadow-lg relative">
                        <img src="https://ui-avatars.com/api/?name=Ni+Luh+Putu&background=9D174D&color=fff" alt="Team" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark">Ni Luh Putu</h3>
                    <p class="text-mesuluh-primary text-xs font-bold uppercase tracking-wider mt-1">Pemimpin Redaksi</p>
                </div>

                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-white shadow-lg relative">
                        <img src="https://ui-avatars.com/api/?name=Ida+Ayu&background=9D174D&color=fff" alt="Team" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark">Ida Ayu</h3>
                    <p class="text-mesuluh-primary text-xs font-bold uppercase tracking-wider mt-1">Redaktur Pelaksana</p>
                </div>

                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-white shadow-lg relative">
                        <img src="https://ui-avatars.com/api/?name=Wayan+Sari&background=9D174D&color=fff" alt="Team" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark">Wayan Sari</h3>
                    <p class="text-mesuluh-primary text-xs font-bold uppercase tracking-wider mt-1">Jurnalis</p>
                </div>

                <div class="group text-center">
                    <div class="w-40 h-40 mx-auto rounded-full overflow-hidden mb-6 border-4 border-white shadow-lg relative">
                        <img src="https://ui-avatars.com/api/?name=Kadek+Adi&background=9D174D&color=fff" alt="Team" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                    </div>
                    <h3 class="font-serif font-bold text-xl text-mesuluh-dark">Kadek Adi</h3>
                    <p class="text-mesuluh-primary text-xs font-bold uppercase tracking-wider mt-1">Web Developer</p>
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
            <a href="mailto:redaksi@mesuluh.com" class="inline-block px-8 py-3 bg-mesuluh-primary text-white font-bold rounded-full hover:bg-white hover:text-mesuluh-dark transition shadow-lg border border-mesuluh-primary">
                Hubungi Kami
            </a>
        </div>
    </section>

</x-layouts.app>