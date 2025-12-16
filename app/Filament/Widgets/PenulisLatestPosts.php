<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PenulisLatestPosts extends BaseWidget
{
    protected static ?string $heading = 'Status Tulisan Terkini';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return auth()->user()->isPenulis();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->where('user_id', auth()->id()) // HANYA TULISAN SENDIRI
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->weight('bold')
                    ->limit(40),

                Tables\Columns\TextColumn::make('status.name')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Published' => 'success',
                        'Review' => 'warning',
                        'Draft' => 'gray',
                        'Revisi', 'Ditolak' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Update Terakhir')
                    ->dateTime('d M H:i')
                    ->color('gray'),
            ])
            ->actions([
                // Tombol Shortcut untuk Edit/Lihat Revisi
                Tables\Actions\Action::make('buka')
                    ->label('Buka')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (Post $record) => route('filament.admin.resources.posts.edit', $record)),
            ])
            ->paginated(false);
    }
}