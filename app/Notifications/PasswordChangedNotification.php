<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class PasswordChangedNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Password Has Been Changed')
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line('Your password has been successfully changed.')
                    ->line('If you did not make this change, please contact support immediately.')
                    ->line('This is to notify you that your password has been changed successfully.')
                    ->line('If you did not perform this action, please contact our support immediately.')
                    ->action('Visit Our Website', url('/'))
                    ->line('Thank you for using our application!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Your password has been successfully changed.',
        ];
    }
}
