<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Produktifitas Redaksi';
    
    protected static ?int $sort = 2;

    // Default filter yang aktif saat pertama buka
    public ?string $filter = 'year';

    // Mendefinisikan opsi filter yang muncul di pojok kanan atas grafik
    protected function getFilters(): ?array
    {
        return [
            'week' => 'Minggu Ini',
            'month' => 'Bulan Ini',
            'year' => 'Tahun Ini',
        ];
    }

    protected function getData(): array
    {
        // Mendeteksi filter yang dipilih user
        $activeFilter = $this->filter;

        // Tentukan rentang waktu berdasarkan filter
        $match = match ($activeFilter) {
            'week' => [
                'start' => now()->startOfWeek(),
                'end' => now()->endOfWeek(),
                'per' => 'perDay', // Kalau mingguan, kita lihat per hari
            ],
            'month' => [
                'start' => now()->startOfMonth(),
                'end' => now()->endOfMonth(),
                'per' => 'perDay', // Kalau bulanan, kita lihat per hari
            ],
            'year' => [
                'start' => now()->startOfYear(),
                'end' => now()->endOfYear(),
                'per' => 'perMonth', // Kalau tahunan, kita lihat per bulan
            ],
            default => [ // Fallback
                'start' => now()->startOfYear(),
                'end' => now()->endOfYear(),
                'per' => 'perMonth',
            ]
        };

        // Query Data
        $data = Trend::model(Post::class)
            ->between(
                start: $match['start'],
                end: $match['end'],
            )
            ->{$match['per']}() // Dinamis: perDay() atau perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Tulisan Diterbitkan',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#8b004b', // Warna Mesuluh Primary
                    'backgroundColor' => '#8b004b20',
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $activeFilter === 'year' 
                ? $value->date // Format bulan (misal: 2024-01)
                : \Carbon\Carbon::parse($value->date)->format('d M') // Format tanggal (misal: 17 Dec)
            ),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    // Admin Only
    public static function canView(): bool
    {
        return ! auth()->user()->isPenulis();
    }
}