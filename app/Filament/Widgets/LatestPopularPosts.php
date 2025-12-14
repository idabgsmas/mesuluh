<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPopularPosts extends BaseWidget
{
    protected static ?string $heading = 'Tulisan Paling Banyak Dibaca';
    
    // protected int | string | array $columnSpan = 'full'; // Memanjang penuh
    
    protected static ?int $sort = 4; // Urutan ke-4

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()->orderBy('views', 'desc')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->weight('bold')
                    ->toolTip(fn (Tables\Columns\TextColumn $column): ?string => $column->getState())
                    ->wrap() // <--- INI KUNCINYA: Biar teks turun ke bawah
                    ->lineClamp(2) // Maksimal 2 baris agar tidak terlalu tinggi
                    ->description(fn ($record) => $record->category->name) // Taruh kategori di BAWAH judul
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->limit(50),
                // Tables\Columns\TextColumn::make('category.name')
                //     ->label('Kategori')
                //     ->badge()
                //     ->color(fn ($record) => $record->category->text_color ? 'gray' : 'primary'), // Bisa disesuaikan
                Tables\Columns\TextColumn::make('views')
                    ->label('Pembaca')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => number_format($state))
                    ->alignEnd(),
            ])
            ->paginated(false); // Matikan pagination karena cuma Top 5
    }
}