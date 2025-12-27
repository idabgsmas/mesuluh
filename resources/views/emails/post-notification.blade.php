<x-mail::message>
# {{ $customTitle }}

Halo, ada perkembangan terbaru terkait tulisan di Mesuluh:

**Judul:** {{ $post->title }}  
**Penulis:** {{ $post->user->name }}  
**Status:** {{ $post->status->name }}

<x-mail::button :url="config('app.url') . '/admin/posts/' . $post->id . '/edit'">
Lihat Tulisan
</x-mail::button>

Terima kasih,<br>
Redaksi {{ config('app.name') }}
</x-mail::message>