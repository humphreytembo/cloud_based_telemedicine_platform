<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\ResendEmailService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force correct asset URL for XAMPP Windows
        if (config('app.env') === 'local') {
            $this->app['url']->forceRootUrl(config('app.url'));
        }

        View::composer('doctor.layout', function ($view) {

            $unreadMessages = 0;

            if (Auth::check()) {

                $unreadMessages = Message::where('receiver_id', Auth::id())
                    ->where('is_read', 0)
                    ->count();
            }

            $view->with('unreadMessages', $unreadMessages);
        });
    }
}