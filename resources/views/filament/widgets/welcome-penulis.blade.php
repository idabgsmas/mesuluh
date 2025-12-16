<x-filament::section>
    <div class="flex items-center gap-6">
        
        {{-- Bagian Kiri --}}
        <div class="flex-1">
            
            {{-- UPDATE: Tambahkan 'dark:text-white' --}}
            <h2 class="text-2xl font-bold text-mesuluh-primary dark:text-white mb-2 font-serif">
                Halo, {{ $user->name }}! 👋
            </h2>
            
            {{-- UPDATE: Tambahkan 'dark:text-gray-400' agar teks deskripsi juga enak dibaca --}}
            <p class="text-gray-500 dark:text-gray-400 mb-4 font-sans">
                Sudah punya ide cerita menarik hari ini? Mari suarakan perspektifmu.
                Ingat untuk selalu mengecek kembali ejaan sebelum mengajukan review.
            </p>
            
            <div class="flex gap-3">
                <a href="{{ route('filament.admin.resources.posts.create') }}" 
                   class="px-4 py-2 bg-mesuluh-primary text-black dark:text-white rounded-lg font-bold text-sm transition shadow-sm hover:opacity-90">
                    + Buat Tulisan Baru
                </a>
                
                @if(Route::has('pedoman'))
                    {{-- UPDATE: Perbaiki warna tombol sekunder saat dark mode --}}
                    <a href="{{ route('pedoman') }}" target="_blank"
                       class="px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 rounded-lg font-bold text-sm transition">
                        Baca Pedoman
                    </a>
                @endif
            </div>
        </div>

        {{-- Bagian Kanan: Hiasan Visual --}}
        {{-- UPDATE: Tambahkan 'dark:opacity-100 dark:text-gray-600' agar ikon terlihat samar tapi jelas --}}
        <div class="hidden md:block opacity-10 dark:opacity-20 text-mesuluh-primary dark:text-white">
             <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path><path d="M2 2l7.586 7.586"></path><circle cx="11" cy="11" r="2"></circle></svg>
        </div>
        
    </div>
</x-filament::section>