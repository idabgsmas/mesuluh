<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\ContactMessage;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class ContactMessageObserver
{
    // Skenario: Pesan kontak masuk dari pengunjung situs
    public function created(ContactMessage $message): void
    {
        $admin = User::where('role_id', 1)->get();
        Notification::make()
            ->title('Pesan Masuk Baru')
            ->body("Dari: \"{$message->name}\". Perihal: \"{$message->subject}\".")
            ->icon('heroicon-o-envelope')
            ->actions([
                Action::make('read')->url("/admin/contact-messages"),
            ])
            ->sendToDatabase($admin);
    }

}