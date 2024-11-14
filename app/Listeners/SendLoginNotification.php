<?php

namespace App\Listeners;

use App\Notifications\LoginNotification;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLoginNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        // Send login notification to the user
        $event->user->notify(new LoginNotification());
 
    }
}
