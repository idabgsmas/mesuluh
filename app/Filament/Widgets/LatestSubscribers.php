<?php

namespace App\Filament\Widgets;

use App\Models\Subscriber;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSubscribers extends BaseWidget
{
    protected static ?string $heading = 'Subscriber Baru';
    
    protected static ?int $sort = 5;

    public static function canView(): bool 
    {
        return auth()->user()->isAdmin();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Subscriber::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->copyable(), // Biar Admin gampang copy email
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Bergabung')
                    ->since() // Tampil "2 minutes ago"
                    ->color('gray'),
            ])
            ->paginated(false);
    }
}