<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Tambahkan penjadwalan tugas untuk notifikasi tulisan terjadwal tayang
Schedule::command('app:notify-live-posts')->everyMinute();

// Tambahkan penjadwalan tugas untuk pembuatan sitemap setiap hari pukul 02:00
Schedule::command('sitemap:generate')->dailyAt('02:00');

// Tambahkan penjadwalan tugas untuk mengingatkan editor tentang tulisan yang menunggu review lebih dari 24 jam
Schedule::command('app:remind-pending-posts')->dailyAt('09:00');