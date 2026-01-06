<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\PostView;
use App\Models\Subscriber;
use App\Models\ContactMessage;
use App\Observers\PostObserver;
use App\Observers\UserObserver;
use App\Observers\PostViewObserver;
use Illuminate\Support\Facades\URL;
use App\Observers\SubscriberObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\ContactMessageObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // INI BAGIAN YANG TERTINGGAL: Menghubungkan Model dengan Observer
        Post::observe(PostObserver::class);
        User::observe(UserObserver::class);
        Subscriber::observe(SubscriberObserver::class);
        ContactMessage::observe(ContactMessageObserver::class);
        PostView::observe(PostViewObserver::class);

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}