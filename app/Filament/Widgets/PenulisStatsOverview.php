<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PenulisStatsOverview extends BaseWidget
{
    // Atur Sort agar muncul paling atas
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        // Hanya muncul untuk Penulis
        return auth()->user()->isPenulis();
    }

    protected function getStats(): array
    {
        $userId = auth()->id();

        // Hitung data dasar
        $totalPublished = Post::where('user_id', $userId)->where('status_id', 3)->count();
        $totalViews = Post::where('user_id', $userId)->sum('views');
        
        // Hitung Rata-rata (Engagement)
        $averageViews = $totalPublished > 0 ? ($totalViews / $totalPublished) : 0;

        return [
            Stat::make('Tulisan Terbit', Post::where('user_id', $userId)->where('status_id', 3)->count())
                ->description('Artikel Anda yang sudah tayang')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Total Pembaca', number_format(Post::where('user_id', $userId)->sum('views')))
                ->description('Orang membaca tulisan Anda')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary'),

            // METRIK ENGAGEMENT BARU:
            Stat::make('Rata-rata Pembaca', number_format($averageViews, 1))
                ->description('Views per tulisan (Engagement)')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($averageViews > 100 ? 'success' : 'info'), // Contoh threshold warna

            Stat::make('Dalam Antrean', Post::where('user_id', $userId)->whereIn('status_id', [1, 2, 4])->count())
                ->description('Draft, Review, atau Revisi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}