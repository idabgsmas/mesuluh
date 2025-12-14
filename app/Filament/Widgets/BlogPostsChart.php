<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Produktifitas Redaksi (Tulisan per Bulan)';
    
    // Agar grafik memanjang penuh
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2; // Urutan ke-2 (di bawah kartu)

    protected function getData(): array
    {
        // Ambil data tulisan per bulan dalam 1 tahun terakhir
        $data = Trend::model(Post::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Tulisan Diterbitkan',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#8b004b', // Warna Mesuluh Primary
                    'backgroundColor' => '#8b004b20', // Transparan
                    'fill' => true,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Jenis grafik: Line (Garis)
    }
}