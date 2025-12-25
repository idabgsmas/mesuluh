<?php

namespace App\Observers;

use App\Models\PostView;
use Filament\Notifications\Notification;

class PostViewObserver
{
    public function created(PostView $postView): void
    {
        $post = $postView->post;
        $viewCount = $post->views()->count();

        // Milestone: 100, 500, 1000 views
        if (in_array($viewCount, [100, 500, 1000])) {
            Notification::make()
                ->title('Pencapaian Baru!')
                ->body("Keren! Tulisan Anda **{$post->title}** telah dibaca sebanyak **{$viewCount}** kali.")
                ->icon('heroicon-o-fire')
                ->iconColor('warning')
                ->sendToDatabase($post->user);
        }
    }
}