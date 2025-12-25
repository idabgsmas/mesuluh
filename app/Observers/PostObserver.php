<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class PostObserver
{
    public function created(Post $post): void
    {
        // Jika saat dibuat statusnya langsung 'Pending' (ID 2)
        if ($post->status_id == 2) {
            $this->notifyAdminEditor($post);
        }
        // dd('Observer Terpanggil!');
    }

    public function updated(Post $post): void
    {

        if ($post->isDirty('status_id')) {
            $penulis = $post->user;
            $adminEditor = User::whereIn('role_id', [1, 2])->get();

            switch ($post->status_id) {
                case 2: // Pending / Perlu Review
                    Notification::make()
                        ->title('Tulisan Perlu Review')
                        ->body("Tulisan **{$post->title}** baru saja dikirim/direvisi oleh **{$penulis->name}**.")
                        ->warning()
                        ->actions([Action::make('review')->url("/admin/posts/{$post->id}/edit")])
                        ->sendToDatabase($adminEditor);
                    break;

                case 3: // Published
                    Notification::make()
                        ->title('Tulisan Terbit!')
                        ->body("Selamat! Tulisan **{$post->title}** sudah tayang.")
                        ->success()
                        ->sendToDatabase($penulis);
                    break;

                case 4: // Revision
                    Notification::make()
                        ->title('Perlu Revisi')
                        ->body("Tulisan **{$post->title}**: " . ($post->revision_notes ?? 'Cek catatan revisi.'))
                        ->danger()
                        ->sendToDatabase($penulis);
                    break;

                case 1: // Draft / Takedown (Jika sebelumnya Published)
                    if ($post->getOriginal('status_id') == 3) {
                        Notification::make()
                            ->title('Tulisan Di-takedown')
                            ->body("Tulisan **{$post->title}** telah ditarik dari publikasi.")
                            ->danger()
                            ->sendToDatabase($penulis);
                    }
                    break;
            }
        }
    }

    // Buat fungsi private agar kodenya rapi dan tidak duplikat
    private function notifyAdminEditor(Post $post)
    {
        $recipients = \App\Models\User::whereIn('role_id', [1, 2])->get();

        \Filament\Notifications\Notification::make()
            ->title('Tulisan Baru Perlu Review')
            ->body("Tulisan **{$post->title}** dikirim oleh **{$post->user->name}**.")
            ->icon('heroicon-o-document-magnifying-glass')
            ->warning()
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->label('Buka Tulisan')
                    ->url("/admin/posts/{$post->id}/edit"),
            ])
            ->sendToDatabase($recipients);
    }
}