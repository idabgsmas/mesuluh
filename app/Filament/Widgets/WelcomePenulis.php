<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomePenulis extends Widget
{
    // Ini kuncinya: kita hubungkan class ini dengan file view (blade) yang akan kita buat
    protected static string $view = 'filament.widgets.welcome-penulis';

    // Agar widget ini memanjang penuh (seperti banner)
    // Memaksa widget mengambil lebar penuh
    public function getColumnSpan(): int | string | array
    {
        return 'full'; // Ini akan otomatis mengambil 3 kolom yang sudah kita set di Dashboard
    }

    // Taruh di urutan paling atas
    protected static ?int $sort = 0;

    // Logika Visibilitas: Hanya untuk Penulis
    public static function canView(): bool
    {
        return auth()->user()->isPenulis();
    }

    // Mengirim data user ke tampilan (view)
    protected function getViewData(): array
    {
        return [
            'user' => auth()->user(),
        ];
    }
}