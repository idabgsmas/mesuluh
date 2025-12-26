<x-layouts.app 
    :title="$category->name"
    :description="$category->description ?? 'Arsip tulisan kategori ' . $category->name"
>

    <div class="pt-32 pb-12 bg-mesuluh-cream border-b border-mesuluh-primary/10">
        <div class="container mx-auto px-4 text-center">
            
            <span style="color: {{ $category->text_color ?? '#9D174D' }}; background-color: {{ $category->bg_color ?? '#FCE7F3' }}; border-color: {{ $category->text_color ?? '#9D174D' }}20;"
                  class="font-bold tracking-widest uppercase text-xs mb-3 inline-block px-3 py-1 rounded-full border">
                Kategori
            </span>
            
            <h1 class="font-serif text-4xl md:text-6xl font-bold text-mesuluh-dark mb-4 capitalize">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-gray-600 max-w-2xl mx-auto font-sans text-lg">
                    {{ $category->description }}
                </p>
            @endif
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
                                    <span style="background-color: {{ $category->text_color ?? '#9D174D' }}" 
                                          class="text-white px-2 py-1 rounded">
                                        {{ $category->name }}
                                    </span>
                                    <span>{{ $featured->user->name }}</span>
                                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
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
                        <h3 class="font-bold text-xl text-mesuluh-dark font-serif">Terbaru</h3>
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
                                            <span style="color: {{ $category->text_color ?? '#9D174D' }}" class="font-bold">
                                                {{ $post->user->name }}
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
                        <p class="text-gray-500 italic">Belum ada tulisan lain di kategori ini.</p>
                    @endif

                @else
                    <div class="text-center py-20 opacity-50 border-2 border-dashed border-gray-200 rounded-xl">
                        <p class="font-serif text-xl">Belum ada tulisan di kategori ini.</p>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-4 space-y-10">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-32">
                    <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                        <h3 class="font-serif text-lg font-bold text-mesuluh-dark">Pilihan Editor</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-mesuluh-primary" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" /></svg>
                    </div>

                    <div class="space-y-6">
                        @forelse($editorsChoice as $choice)
                            <article class="group flex gap-4 items-start">
                                <span class="text-3xl font-serif font-bold text-gray-200 -mt-2 group-hover:text-mesuluh-primary transition">
                                    {{ $loop->iteration }}
                                </span>
                                <div>
                                    <div style="color: {{ $choice->category->text_color ?? '#9D174D' }}"
                                         class="text-[10px] font-bold uppercase tracking-wider mb-1">
                                        {{ $choice->category->name }}
                                    </div>

                                    <a href="{{ route('posts.show', $choice) }}">
                                        <h4 class="font-bold text-mesuluh-dark leading-snug group-hover:text-mesuluh-primary transition">
                                            {{ $choice->title }}
                                        </h4>
                                    </a>
                                    <span class="text-xs text-gray-400 mt-1 block">{{ $choice->user->name }} | {{ $choice->published_at->format('d M Y') }}</span>
                                    {{-- <span class="text-xs text-gray-400 mt-1 block">{{ $choice->user->name }}</span> --}}
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada pilihan editor.</p>
                        @endforelse
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="text-center mb-4">
                            <p class="text-sm font-bold text-mesuluh-dark font-serif">Kabar Terbaru</p>
                            <p class="text-xs text-gray-500">Dapatkan tulisan terpilih setiap minggunya.</p>
                        </div>

                        @if(session('success'))
                            <div class="mb-3 p-2 bg-green-50 text-green-700 text-xs rounded border border-green-200 text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        @error('email')
                            <div class="mb-3 p-2 bg-red-50 text-red-700 text-xs rounded border border-red-200 text-center">
                                {{ $message }}
                            </div>
                        @enderror

                        <form action="{{ route('subscribe.store') }}" method="POST">
                            @csrf
                            <div class="flex flex-col gap-2">
                                <input type="email" name="email" placeholder="Alamat Email Anda" required
                                       class="w-full px-3 py-2 rounded-lg bg-gray-50 border border-gray-200 focus:outline-none focus:border-mesuluh-primary focus:bg-white text-sm placeholder-gray-400 transition">
                                
                                <button type="submit" class="w-full py-2 bg-mesuluh-primary text-white font-bold text-xs rounded-lg hover:bg-mesuluh-dark transition shadow-sm">
                                    Langganan
                                </button>
                            </div>
                        </form>
                        
                        <p class="text-[10px] text-gray-400 text-center mt-3">
                            Bebas spam. Berhenti berlangganan kapan saja.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>

</x-layouts.app>