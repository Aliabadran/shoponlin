<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Verified;
use App\Events\UserInteractionLogged;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendLoginNotification;
use App\Listeners\UpdateUserPreferences;
use App\Listeners\SendVerificationSuccessNotification;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Verified::class => [
            SendVerificationSuccessNotification::class, // Add this listener
        ],

        Login::class => [
            SendLoginNotification::class, // Add this listener
        ],
        UserInteractionLogged::class => [
            UpdateUserPreferences::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
