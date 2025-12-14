<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryStatsChart extends ChartWidget
{
    protected static ?string $heading = 'Komposisi Tulisan per Rubrik';
    
    // PENTING: Urutan ke-3 (Setelah Kartu Statistik & Grafik Line)
    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '476px'; // Paksa tinggi maksimal

    protected function getData(): array
    {
        $categories = Category::withCount('posts')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Tulisan',
                    'data' => $categories->pluck('posts_count'),
                    'backgroundColor' => [
                        '#8b004b', // Primary (Magenta)
                        '#f59e0b', // Amber
                        '#10b981', // Emerald
                        '#3b82f6', // Blue
                        '#6366f1', // Indigo
                        '#ec4899', // Pink
                    ],
                    'hoverOffset' => 4,
                ],
            ],
            'labels' => $categories->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}