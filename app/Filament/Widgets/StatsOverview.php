<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\Subscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{

    public static function canView(): bool
    {
        // Boleh dilihat siapa saja, KECUALI Penulis
        return ! auth()->user()->isPenulis();
    }

    // Agar widget ini me-refresh datanya sendiri setiap 30 detik (Realtime-ish)
    protected static ?string $pollingInterval = '30s';
    
    protected function getStats(): array
    {
        return [
            // 1. KARTU PENTING: Antrean Review
            Stat::make('Butuh Review', Post::where('status_id', 2)->count()) // Status 2 = Review
                ->description('Tulisan menunggu persetujuan')
                ->descriptionIcon('heroicon-m-bell-alert') // Ikon Lonceng
                ->color('danger') // Merah agar menarik perhatian
                ->chart([2, 5, 10, 5, 2]), // Dummy chart   
            // Kartu 1: Total Tulisan Terbit
            Stat::make('Tulisan Terbit', Post::whereHas('status', fn($q) => $q->where('name', 'Published'))->count())
                ->description('Artikel aktif di website')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Dummy chart kecil (hiasan)

            // Kartu 2: Total Pembaca (Views)
            Stat::make('Total Pembaca', number_format(Post::sum('views')))
                ->description('Akumulasi semua tulisan')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success')
                ->chart([15, 4, 10, 2, 12, 4, 12]),

            // Kartu 3: Subscriber Newsletter
            Stat::make('Pelanggan Newsletter', Subscriber::count())
                ->description('Total email terdaftar')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),
        ];
    }
}