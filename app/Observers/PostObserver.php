<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class PostObserver
{
    /**
     * Skenario 1: Penulis baru buat tulisan & langsung set status ke 'Review' (ID 2)
     */
    public function created(Post $post): void
    {
        if ($post->status_id == 2) {
            $this->notifyAdminEditor($post, 'Tulisan Baru Masuk');
        }
    }

    /**
     * Skenario 2: Penulis update status dari Draft ke Review, atau Admin feedback ke Penulis
     */
    public function updated(Post $post): void
    {
        // Gunakan wasChanged untuk mengecek kolom yang baru saja berubah di database
        if ($post->wasChanged('status_id')) {
            $penulis = $post->user;

            switch ($post->status_id) {
                case 2: // Review / Pending
                    $this->notifyAdminEditor($post, 'Tulisan Perlu Review');
                    break;

                case 3: // Published / Terbit
                    Notification::make()
                        ->title('Tulisan Telah Terbit!')
                        ->body("Selamat! Tulisan **{$post->title}** sudah tayang.")
                        ->icon('heroicon-o-check-circle')
                        ->success()
                        ->sendToDatabase($penulis);
                    break;

                case 4: // Revision / Revisi
                    Notification::make()
                        ->title('Perlu Revisi')
                        ->body("Tulisan **{$post->title}**: " . ($post->revision_notes ?? 'Cek catatan revisi.'))
                        ->icon('heroicon-o-pencil-square')
                        ->warning()
                        ->sendToDatabase($penulis);
                    break;

                case 1: // Draft / Takedown (Jika sebelumnya Published)
                    if ($post->getOriginal('status_id') == 3) {
                        Notification::make()
                            ->title('Tulisan Di-takedown')
                            ->body("Tulisan **{$post->title}** ditarik dari publikasi.")
                            ->icon('heroicon-o-arrow-down-tray')
                            ->danger()
                            ->sendToDatabase($penulis);
                    }
                    break;
            }
        }
    }

    /**
     * Helper untuk kirim notifikasi ke Admin & Editor
     */
    private function notifyAdminEditor(Post $post, string $title): void
    {
        $recipients = User::whereIn('role_id', [1, 2])->get();

        if ($recipients->count() > 0) {
            Notification::make()
                ->title($title)
                ->body("Tulisan **{$post->title}** diajukan oleh **{$post->user->name}**.")
                ->warning()
                ->actions([
                    Action::make('review')->url("/admin/posts/{$post->id}/edit")
                ])
                ->sendToDatabase($recipients);
        }
    }
}