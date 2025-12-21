<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopAuthors extends BaseWidget
{
    protected static ?string $heading = 'Penulis Paling Produktif';
    
    protected static ?int $sort = 4; // Taruh di bawah grafik
    
    // Admin Only
    public static function canView(): bool 
    {
        return auth()->user()->isAdmin();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->whereIn('role_id', [2, 3]) // Ambil Editor & Penulis saja
                    ->withCount('posts') // Hitung jumlah tulisan
                    ->withSum('posts', 'views') // Hitung total views
                    ->orderByDesc('posts_sum_views') // Urutkan dari yang paling banyak dibaca
                    ->limit(5)
            )
            ->columns([
                // Tables\Columns\ImageColumn::make('avatar')
                //     ->circular()
                //     ->label(''),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('posts_count')
                    ->label('Tulisan')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('posts_sum_views')
                    ->label('Total Dibaca')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => number_format($state)),
            ])
            ->paginated(false);
    }
}