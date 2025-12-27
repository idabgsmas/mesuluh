<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Mail\AdminContactMail; // Import mail
use Illuminate\Support\Facades\Mail; // Import Facade
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class ContactMessageObserver
{
    public function created(ContactMessage $message): void
    {
        $admins = User::where('role_id', 1)->get();

        // 1. Notifikasi Database (Lonceng)
        Notification::make()
            ->title('Pesan Masuk Baru')
            ->body("Dari: \"{$message->name}\". Perihal: \"{$message->subject}\".")
            ->icon('heroicon-o-envelope')
            ->actions([
                Action::make('read')->url("/admin/contact-messages"),
            ])
            ->sendToDatabase($admins);

        // 2. Kirim Email ke Admin
        if ($admins->count() > 0) {
            Mail::to($admins)->send(new AdminContactMail($message));
        }
    }
}