<?php

namespace App\Observers;

use App\Models\Subscriber;
use App\Models\User;
use App\Mail\AdminSubscriberMail; // Import mail
use Illuminate\Support\Facades\Mail; // Import Facade
use Filament\Notifications\Notification;

class SubscriberObserver
{
    public function created(Subscriber $subscriber): void
    {
        $admins = User::where('role_id', 1)->get();

        // 1. Notifikasi Database (Lonceng)
        Notification::make()
            ->title('Pelanggan Baru')
            ->body("Email \"{$subscriber->email}\" baru saja berlangganan Mesuluh.")
            ->icon('heroicon-o-user-plus')
            ->sendToDatabase($admins);

        // 2. Kirim Email ke Admin
        if ($admins->count() > 0) {
            Mail::to($admins)->send(new AdminSubscriberMail($subscriber));
        }
    }
}