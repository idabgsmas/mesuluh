<x-mail::message>
# Ada Pesan Masuk Baru

Halo Admin, Anda menerima pesan baru dari pengunjung situs:

**Nama:** {{ $contactMessage->name }}  
**Email:** {{ $contactMessage->email }}  
**Perihal:** {{ $contactMessage->subject }}  

**Pesan:** {{ $contactMessage->message }}

<x-mail::button :url="config('app.url') . '/admin/contact-messages'">
Buka Kotak Masuk
</x-mail::button>

Terima kasih,<br>
Sistem {{ config('app.name') }}
</x-mail::message>