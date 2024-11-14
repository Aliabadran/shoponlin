<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\VerificationSuccessNotification;

class SendVerificationSuccessNotification
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
    public function handle(Verified $event)
    {
        // Send notification to the user when they successfully verify their email
        $event->user->notify(new VerificationSuccessNotification());
    }
}
