<x-layouts.app 
    title="Hubungi Redaksi" 
    description="Sapa redaksi Mesuluh untuk kolaborasi, kritik, dan saran."
>

    <div class="pt-32 pb-32 bg-mesuluh-cream dark:bg-gray-900 text-center px-4 transition-colors duration-300">
        <span class="text-mesuluh-primary font-bold tracking-widest uppercase text-xs mb-4 inline-block bg-mesuluh-primary/5 px-3 py-1 rounded-full border border-mesuluh-primary/10">
            Hubungi Kami
        </span>
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-mesuluh-dark dark:text-white mb-6">
            Sapa Redaksi
        </h1>
        <p class="text-gray-500 dark:text-gray-400 max-w-xl mx-auto font-sans leading-relaxed">
            Punya ide liputan, kritik membangun, atau sekadar ingin menyapa? Kami selalu membuka pintu untuk diskusi hangat.
        </p>
    </div>

    <div class="container mx-auto px-4 pb-20 -mt-20 relative z-10">
        
        <div class="bg-mesuluh-surface dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col lg:flex-row transition-colors duration-300">
            
            <div class="lg:w-5/12 bg-mesuluh-primary text-white p-10 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-black/10 rounded-full blur-2xl"></div>
                
                <h3 class="font-serif text-2xl font-bold mb-8 relative z-10">Kantor Redaksi</h3>
                
                <div class="space-y-6 relative z-10">
                    <div class="flex items-start gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mt-1 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <div>
                            <p class="font-bold">Mesuluh HQ</p>
                            <p class="text-white/80 text-sm leading-relaxed">
                                Jl. Hayam Wuruk No. 123,<br>
                                Sumerta Kelod, Denpasar Timur,<br>
                                Bali, Indonesia 80239
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mt-1 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        <div>
                            <p class="font-bold">Surel</p>
                            <a href="mailto:mesuluhproject@gmail.com" class="text-white/80 text-sm hover:text-white hover:underline">mesuluhproject@gmail.com</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mt-1 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        <div>
                            <p class="font-bold">WhatsApp</p>
                            <p class="text-white/80 text-sm">+62 812-3721-3897</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 rounded-xl overflow-hidden shadow-lg border-2 border-white/20">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.209673626244!2d115.23366887588335!3d-8.671569491376174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2409b0e5e80db%3A0xe27334e2475f66!2sJl.%20Hayam%20Wuruk%2C%20Denpasar%2C%20Bali!5e0!3m2!1sen!2sid!4v1710319451234!5m2!1sen!2sid" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="grayscale hover:grayscale-0 transition duration-700"></iframe>
                </div>

            </div>

            <div class="lg:w-7/12 p-10 lg:p-16">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama Lengkap</label>
                            <input type="text" id="name" name="name" placeholder="Nama Anda" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:border-mesuluh-primary focus:ring-1 focus:ring-mesuluh-primary outline-none transition dark:text-white placeholder-gray-400">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="email" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Alamat Email</label>
                            <input type="email" id="email" name="email" placeholder="contoh@email.com" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:border-mesuluh-primary focus:ring-1 focus:ring-mesuluh-primary outline-none transition dark:text-white placeholder-gray-400">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="subject" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Subjek Pesan</label>
                        <select id="subject" name="subject" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:border-mesuluh-primary focus:ring-1 focus:ring-mesuluh-primary outline-none transition dark:text-white text-gray-700">
                            <option>Pilih tujuan pesan...</option>
                            <option>Kerjasama & Kolaborasi</option>
                            <option>Kritik & Saran</option>
                            <option>Kiriman Tulisan Pembaca</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="message" class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Isi Pesan</label>
                        <textarea id="message" name="message" rows="5" placeholder="Tuliskan pesan Anda di sini dengan jelas..." 
                            class="w-full px-4 py-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 focus:border-mesuluh-primary focus:ring-1 focus:ring-mesuluh-primary outline-none transition dark:text-white placeholder-gray-400 resize-none"></textarea>
                    </div>

                    <button type="submit" class="inline-block px-8 py-3 bg-mesuluh-dark dark:bg-white text-white dark:text-mesuluh-dark font-bold rounded-lg hover:bg-mesuluh-primary dark:hover:bg-gray-200 transition shadow-lg w-full md:w-auto">
                        Kirim Pesan →
                    </button>

                </form>
            </div>

        </div>
    </div>

</x-layouts.app>