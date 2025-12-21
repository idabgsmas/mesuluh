<?php

namespace App\Filament\Widgets;

use App\Models\SiteVisit;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;

class VisitorTrafficChart extends ChartWidget
{
    protected static ?string $heading = 'Trafik Kunjungan Website';
    
    protected static ?int $sort = 7;
    
    public static function canView(): bool
    {
        // Hanya muncul untuk Admin
        return auth()->user()->isAdmin();
    }

    public ?string $filter = 'week';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hari Ini (Per Jam)',
            'week' => 'Minggu Ini (Per Hari)',
            'month' => 'Bulan Ini (Per Hari)',
            'year' => 'Tahun Ini (Per Bulan)',
        ];
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        // 1. Tentukan Rentang Waktu & Unit
        $match = match ($activeFilter) {
            'today' => [
                'start' => now()->startOfDay(),
                'end' => now()->endOfDay(),
                'per' => 'perHour', 
                'format' => 'H:00',
                'unit' => 'hour', // Untuk query unik nanti
            ],
            'week' => [
                'start' => now()->startOfWeek(),
                'end' => now()->endOfWeek(),
                'per' => 'perDay',
                'format' => 'D (d M)',
                'unit' => 'day',
            ],
            'month' => [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
                'per' => 'perDay',
                'format' => 'd M',
                'unit' => 'day',
            ],
            'year' => [
                'start' => now()->startOfYear(),
                'end' => now()->endOfYear(),
                'per' => 'perMonth',
                'format' => 'M Y',
                'unit' => 'month',
            ],
            default => [
                'start' => now()->startOfWeek(),
                'end' => now()->endOfWeek(),
                'per' => 'perDay',
                'format' => 'd M',
                'unit' => 'day',
            ],
        };

        // 2. DATASET 1: Total Kunjungan (Page Views)
        // Kita gunakan Trend package karena dia otomatis mengisi tanggal yang kosong dengan 0
        $dataTotal = Trend::model(SiteVisit::class)
            ->between(
                start: $match['start'],
                end: $match['end'],
            )
            ->{$match['per']}()
            ->count();

        // 3. DATASET 2: Pengunjung Unik (Unique Visitors)
        // Kita loop hasil $dataTotal untuk menghitung IP unik pada setiap titik waktunya
        $dataUnique = $dataTotal->map(function (TrendValue $value) use ($match) {
            
            // Parse tanggal dari grafik (misal: "2024-12-01 14:00")
            $date = Carbon::parse($value->date);
            
            // Tentukan rentang waktu spesifik (misal: jam 14:00 s.d 14:59)
            $start = $date->copy()->startOf($match['unit']);
            $end   = $date->copy()->endOf($match['unit']);

            // Hitung Distinct IP pada rentang tersebut
            return SiteVisit::query()
                ->whereBetween('created_at', [$start, $end])
                ->distinct('ip_address')
                ->count('ip_address');
        });

        // 4. Return Data ke Chart
        return [
            'datasets' => [
                [
                    'label' => 'Total Kunjungan',
                    'data' => $dataTotal->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#0ea5e9', // Biru Langit
                    'backgroundColor' => '#0ea5e920',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Pengunjung Unik',
                    'data' => $dataUnique, // Data hasil perhitungan manual kita
                    'borderColor' => '#f59e0b', // Oranye/Kuning
                    'backgroundColor' => 'transparent', // Tidak perlu fill agar tidak tumpang tindih
                    'borderDash' => [5, 5], // Garis putus-putus untuk membedakan
                    'tension' => 0.4,
                ],
            ],
            'labels' => $dataTotal->map(fn (TrendValue $value) => 
                \Carbon\Carbon::parse($value->date)->format($match['format'])
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}