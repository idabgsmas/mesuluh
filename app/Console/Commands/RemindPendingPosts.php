<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemindPendingPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-pending-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingPosts = \App\Models\Post::where('status_id', 2)
            ->where('updated_at', '<=', now()->subDay())
            ->get();

        foreach ($pendingPosts as $post) {
            $admins = \App\Models\User::whereIn('role_id', [1, 2])->get();
            \Filament\Notifications\Notification::make()
                ->title('Colekan Editor: Tulisan Terbengkalai')
                ->body("Tulisan \"{$post->title}\" sudah menunggu review lebih dari 24 jam.")
                ->sendToDatabase($admins);
        }
    }
}
