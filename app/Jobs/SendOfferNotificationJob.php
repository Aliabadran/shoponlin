<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use App\Models\NotificationContent;
use App\Notifications\OfferNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOfferNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notificationContentId;
    /**
     * Create a new job instance.
     */
    public function __construct($notificationContentId)
    {
        $this->notificationContentId = $notificationContentId;
    }
    /**
     * Execute the job.
     */
    public function handle()
    {
        $notificationContent = NotificationContent::find($this->notificationContentId);

        if (!$notificationContent) {
            return;
        }

        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new OfferNotification([
                'title' => $notificationContent->title,
                'message' => $notificationContent->message,
                'url' => $notificationContent->url,
            ]));

        }
// php artisan queue:work --timeout=120
// php artisan queue:retry all


}




