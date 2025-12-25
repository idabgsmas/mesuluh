<?php

namespace App\Observers;

use App\Models\User;
use Filament\Notifications\Notification;

class UserObserver
{
    public function created(User $user): void
    {
        // Notifikasi ke Admin jika ada Penulis Baru
        $admins = User::where('role_id', 1)->get();
        Notification::make()
            ->title('Rekan Baru Bergabung')
            ->body("**{$user->name}** telah bergabung sebagai {$user->role->name}.")
            ->icon('heroicon-o-user-plus')
            ->sendToDatabase($admins);
    }

    public function updated(User $user): void
    {
        // Security: Notifikasi jika Password atau Role berubah
        if ($user->isDirty('password') || $user->isDirty('role_id')) {
            Notification::make()
                ->title('Keamanan Akun')
                ->body('Data sensitif akun Anda (Password/Role) baru saja diperbarui. Jika ini bukan Anda, segera hubungi Admin.')
                ->danger()
                ->sendToDatabase($user);
        }
    }
}