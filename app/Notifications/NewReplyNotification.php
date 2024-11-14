<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReplyNotification extends Notification
{
    use Queueable;

    protected $feedback;
    protected $reply;

    /**
     * Create a new notification instance.
     */
    public function __construct($feedback, $reply)
    {
        $this->feedback = $feedback;
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new reply has been posted to your feedback: ' . $this->feedback->title)
                    ->action('View Reply', url('/feedbacks/' . $this->feedback->id))
                    ->line('Thank you for being a part of our community!');
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toArray($notifiable)
    {
        return [
            'feedback_id' => $this->feedback->id,
            'reply_id' => $this->reply->id,
            'message' => 'A new reply has been posted to your feedback: ' . $this->feedback->title,
        ];
    }
}
