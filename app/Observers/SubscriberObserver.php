<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\ContactMessage;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class SubscriberObserver
{
    // Skenario: Pelanggan baru berlangganan newsletter
    public function created(Subscriber $subscriber): void
    {
        $admin = User::where('role_id', 1)->get();
        Notification::make()
            ->title('Pelanggan Baru')
            ->body("Email **{$subscriber->email}** baru saja berlangganan Mesuluh.")
            ->icon('heroicon-o-user-plus')
            ->sendToDatabase($admin);
    }

}