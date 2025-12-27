<x-mail::message>
# Pelanggan Baru Berlangganan

Halo Admin, ada pengguna baru yang mendaftarkan email untuk buletin Mesuluh:

**Email:** {{ $subscriber->email }}  
**Waktu:** {{ $subscriber->created_at->format('d M Y H:i') }}

<x-mail::button :url="config('app.url') . '/admin/subscribers'">
Lihat Daftar Pelanggan
</x-mail::button>

Terima kasih,<br>
Sistem {{ config('app.name') }}
</x-mail::message>