<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class VisitorStatsOverview extends BaseWidget
{
    // Urutan paling atas
    protected static ?int $sort = 6;

    public static function canView(): bool
    {
        // Hanya muncul untuk Admin
        return auth()->user()->isAdmin();
    }

    protected function getStats(): array
    {
        // ==========================================
        // 1. KUNJUNGAN HARI INI (vs Kemarin)
        // ==========================================
        $today = SiteVisit::whereDate('created_at', today())->count();
        $yesterday = SiteVisit::whereDate('created_at', today()->subDay())->count();
        
        $diffToday = $this->calculateTrend($today, $yesterday);

        // ==========================================
        // 2. KUNJUNGAN MINGGU INI (vs Minggu Lalu)
        // ==========================================
        $week = SiteVisit::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $lastWeek = SiteVisit::whereBetween('created_at', [
            now()->subWeek()->startOfWeek(), 
            now()->subWeek()->endOfWeek()
        ])->count();

        $diffWeek = $this->calculateTrend($week, $lastWeek);

        // ==========================================
        // 3. KUNJUNGAN BULAN INI (vs Bulan Lalu)
        // ==========================================
        $month = SiteVisit::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $lastMonth = SiteVisit::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();

        $diffMonth = $this->calculateTrend($month, $lastMonth);

        // ==========================================
        // 4. PENGUNJUNG UNIK HARI INI (vs Kemarin)
        // ==========================================
        $uniqueToday = SiteVisit::whereDate('created_at', today())->distinct('ip_address')->count('ip_address');
        $uniqueYesterday = SiteVisit::whereDate('created_at', today()->subDay())->distinct('ip_address')->count('ip_address');

        $diffUnique = $this->calculateTrend($uniqueToday, $uniqueYesterday);

        // ==========================================
        // 5 & 6. STATISTIK UMUM (Total & Rata-rata)
        // ==========================================
        $total = SiteVisit::count();
        
        // Hitung rata-rata
        $firstVisitDate = SiteVisit::min('created_at');
        if ($firstVisitDate) {
            $daysActive = max(1, Carbon::parse($firstVisitDate)->diffInDays(now()));
            $avgPerDay = ceil($total / $daysActive);
        } else {
            $avgPerDay = 0;
        }

        // ==========================================
        // RETURN WIDGETS
        // ==========================================
        return [
            // KARTU 1
            Stat::make('Kunjungan Hari Ini', number_format($today))
                ->description($diffToday['desc'] . ' dari kemarin')
                ->descriptionIcon($diffToday['icon'])
                ->color($diffToday['color']),

            // KARTU 2
            Stat::make('Minggu Ini', number_format($week))
                ->description($diffWeek['desc'] . ' dari minggu lalu')
                ->descriptionIcon($diffWeek['icon'])
                ->color($diffWeek['color']),

            // KARTU 3
            Stat::make('Bulan Ini', number_format($month))
                ->description($diffMonth['desc'] . ' dari bulan lalu')
                ->descriptionIcon($diffMonth['icon'])
                ->color($diffMonth['color']),

            // KARTU 4
            Stat::make('Unik Hari Ini', number_format($uniqueToday))
                ->description($diffUnique['desc'] . ' dari kemarin')
                ->descriptionIcon($diffUnique['icon'])
                ->color($diffUnique['color']),

            // KARTU 5 (Statik)
            Stat::make('Rata-rata / Hari', number_format($avgPerDay))
                ->description('Performa harian rata-rata')
                ->descriptionIcon('heroicon-m-scale')
                ->color('gray'),

            // KARTU 6 (Statik)
            Stat::make('Total Kunjungan', number_format($total))
                ->description('Total sepanjang masa')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('primary'),
        ];
    }

    /**
     * Helper Function: Menghitung Persentase Kenaikan/Penurunan
     */
    private function calculateTrend($current, $previous)
    {
        if ($previous == 0) {
            // Jika data lama 0, tapi sekarang ada data -> Naik 100%
            if ($current > 0) {
                return [
                    'desc' => 'Naik 100%',
                    'icon' => 'heroicon-m-arrow-trending-up',
                    'color' => 'success',
                ];
            }
            // Jika sama-sama 0
            return [
                'desc' => 'Stabil',
                'icon' => 'heroicon-m-minus',
                'color' => 'gray',
            ];
        }

        // Hitung selisih
        $diff = $current - $previous;
        
        // Hitung persentase
        $percent = round(($diff / $previous) * 100);

        // Tentukan output
        return [
            'desc' => ($diff >= 0 ? 'Naik ' : 'Turun ') . abs($percent) . '%',
            'icon' => $diff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down',
            'color' => $diff >= 0 ? 'success' : 'danger',
        ];
    }
}