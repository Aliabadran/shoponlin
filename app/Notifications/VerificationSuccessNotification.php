<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationSuccessNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database']; // Send via email and store in the database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Email Verified Successfully')
                    ->line('Your email has been verified successfully!')
                    ->action('Go to Home', url('/'))
                    ->line('Thank you for verifying your email!');
    }
    

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your email has been verified successfully.',
        ];
    }
}
