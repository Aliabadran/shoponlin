<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Observers\UserObserver;

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


    public function boot()
    {

       // User::observe(UserObserver::class); // Register the observer

            // Share order count data with all views
            View::composer('*', function ($view) {
                if (Auth::check()) {
                    $orderCount = Order::where('user_id', Auth::id())->count();
                    $view->with('orderCount', $orderCount);
                }
            });

            // Share unread notifications data with all views
            View::composer('*', function ($view) {
                if (Auth::check()) {
                    $unreadNotifications = Auth::user()->unreadNotifications;
                    $view->with('unreadNotifications', $unreadNotifications);
                }
            });
            View::composer('*', function ($view) {
                if (Auth::check()) {
                    $cartItemCount = CartItem::where('user_id', Auth::id())->count();
                    $view->with('cartItemCount', $cartItemCount);
                }
            });


    }
}
