<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Kita paksa Dashboard menggunakan 3 Kolom agar muat banyak widget
    public function getColumns(): int | string | array
    {
        return 1;
    }
}