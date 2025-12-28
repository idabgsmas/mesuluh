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
                    ->withCount(['posts as published_posts_count' => fn ($query) => $query->where('status_id', 3)])
                    ->withSum(['posts as total_views' => fn ($query) => $query->where('status_id', 3)], 'views')
                    ->orderBy('total_views', 'desc')
                    ->limit(5)
            )
            ->columns([
                // Tables\Columns\ImageColumn::make('avatar')
                //     ->circular()
                //     ->label(''),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Penulis')
                    ->weight('bold'),
                    
                // Tables\Columns\TextColumn::make('posts_count')
                //     ->label('Tulisan')
                //     ->badge()
                //     ->color('gray'),
                
                Tables\Columns\TextColumn::make('published_posts_count')
                    ->label('Tulisan')
                    ->alignCenter(),
                
                // KOLOM ENGAGEMENT:
                Tables\Columns\TextColumn::make('engagement_rate')
                    ->label('Rata-rata Pembaca')
                    ->state(function ($record) {
                        return $record->published_posts_count > 0 
                            ? number_format($record->total_views / $record->published_posts_count, 1) 
                            : 0;
                    })
                    ->badge()
                    ->color('info')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('total_views')
                    ->label('Total Dibaca')
                    ->formatStateUsing(fn ($state) => number_format($state ?? 0))
                    ->alignEnd()
                    ->color('success'),

                // Tables\Columns\TextColumn::make('posts_sum_views')
                //     ->label('Total Dibaca')
                //     ->badge()
                //     ->color('success')
                //     ->formatStateUsing(fn ($state) => number_format($state)),
            ])
            ->paginated(false);
    }
}