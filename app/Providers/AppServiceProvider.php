<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        View::composer('*', function ($view) {   //all pages
            $notifications = Notification::where('user_id', auth()->id())->latest()
                ->take(10)
                ->get();

            $unreadnotification = Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
            // data available in all files
            $view->with('notifications', $notifications);
            $view->with('unreadnotification', $unreadnotification);
        });


        // View::composer('*', function ($view) {

        //     if (auth()->check()) {

        //         $notifications = Notification::where('user_id', auth()->id())
        //             ->latest()
        //             ->take(10)
        //             ->get();

        //         $unreadnotification = Notification::where('user_id', auth()->id())
        //             ->where('is_read', 0)
        //             ->count();
        //     } else {
        //         $notifications = collect();
        //         $unreadnotification = 0;
        //     }

        //     $view->with('notifications', $notifications);
        //     $view->with('unreadnotification', $unreadnotification);
        // });
    }
}
