<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class PopularCategoriesChart extends ChartWidget
{
    protected static ?string $heading = 'Popularitas Rubrik (Total Pembaca)';
    
    // Muncul setelah grafik komposisi tulisan
    protected static ?int $sort = 4;

    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        // Mengambil kategori dengan total sum dari kolom 'views' pada relasi posts
        $categories = Category::withSum('posts as total_views', 'views')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Pembaca',
                    'data' => $categories->pluck('total_views')->map(fn ($views) => $views ?? 0),
                    'backgroundColor' => [
                        '#8b004b', // Mesuluh Primary
                        '#fbbf24', // Amber
                        '#34d399', // Emerald
                        '#60a5fa', // Blue
                        '#a78bfa', // Violet
                        '#f472b6', // Pink
                    ],
                ],
            ],
            'labels' => $categories->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        // Menggunakan tipe 'pie' agar berbeda visualnya dengan 'doughnut' komposisi
        return 'pie';
    }
}