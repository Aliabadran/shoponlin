<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomNotification extends Notification
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }


    public function via($notifiable)
    {
        // Choose the channels where the notification will be sent
        return ['mail', 'database']; // Send to email and store in the database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notification Subject')
            ->greeting('Hello, ' . $notifiable->name)
            ->line($this->message)
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}
