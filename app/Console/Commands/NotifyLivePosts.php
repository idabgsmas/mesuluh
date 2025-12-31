<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Mail\PostNotificationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

class NotifyLivePosts extends Command
{
    // Nama perintah yang dijalankan di terminal/scheduler
    protected $signature = 'app:notify-live-posts';
    protected $description = 'Kirim notifikasi otomatis saat tulisan terjadwal benar-benar tayang (Live)';

    public function handle()
    {
        // KODE INI YANG MENCEGAH SPAM:
        // 1. status_id 3 (Published)
        // 2. published_at <= now() (Sudah masuk waktunya tayang)
        // 3. notification_sent false (BELUM PERNAH dikirimi notifikasi "Live")
        $posts = Post::where('status_id', 3)
            ->where('published_at', '<=', now())
            ->where('notification_sent', false) 
            ->get();

        if ($posts->isEmpty()) {
            $this->info('Tidak ada tulisan terjadwal yang baru tayang saat ini.');
            return;
        }

        foreach ($posts as $post) {
            $penulis = $post->user;
            if (!$penulis) continue;

            $title = 'Tulisan Anda Sudah Tayang!';
            $msg = "Hore! Tulisan \"{$post->title}\" sekarang sudah bisa diakses publik di Mesuluh.";

            // 1. Notifikasi Panel (Database)
            Notification::make()
                ->title($title)
                ->body($msg)
                ->icon('heroicon-o-megaphone')
                ->success()
                ->sendToDatabase($penulis);

            // 2. Email Notifikasi
            Mail::to($penulis->email)->send(new PostNotificationMail($post, $title, $msg));

            // 3. UPDATE FLAG: Tandai sudah terkirim agar robot tidak memproses ini lagi di menit berikutnya
            $post->update(['notification_sent' => true]);

            // Gunakan cara ini agar lebih pasti tersimpan ke database
            // $post->notification_sent = true;
            // $post->save(); //

            $this->info("Berhasil mengirim notifikasi Live untuk: {$post->title}");
        }

        // Opsional: Update sitemap jika ada konten baru yang tayang
        \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
    }
}