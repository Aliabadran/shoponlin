<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferNotification extends Notification
{
    use Queueable;
    
    protected $offerData;


     /**
     * Create a new notification instance.
     */
    public function __construct(array $offerData)
    {
        $this->offerData = $offerData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
                    ->subject($this->offerData['title'])
                    ->line($this->offerData['message'])
                    ->action('View Offer', url($this->offerData['url'] ?? '#'));
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->offerData['title'],
            'message' => $this->offerData['message'],
            'url' => $this->offerData['url'] ?? '#',
        ];
    }
}
