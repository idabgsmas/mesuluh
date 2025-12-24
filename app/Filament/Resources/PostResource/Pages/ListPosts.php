<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab; // Import Tab
use Illuminate\Database\Eloquent\Builder; // Import Builder

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Tulisan Baru')
                ->icon('heroicon-o-plus'),
        ];
    }

    // --- TAMBAHKAN FUNGSI INI ---
    public function getTabs(): array
    {
        $user = auth()->user();

        // Jika user adalah Penulis, tidak perlu tab filter (karena sudah discoped view-nya)
        if ($user->isPenulis()) {
            return [];
        }

        return [
            'all' => Tab::make('Semua Tulisan'),
            
            'my_posts' => Tab::make('Tulisan Saya')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', $user->id)),
            
            'review' => Tab::make('Butuh Review')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_id', 2)) // Status Review
                ->badge(fn () => \App\Models\Post::where('status_id', 2)->count()) // Badge jumlah
                ->badgeColor('warning'),
        ];
    }
}