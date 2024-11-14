<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderVerificationNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Send via email and store in database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Order Verification Sent')
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line('An email has been sent to verify your order with ID: ' . $this->order->id)
                    ->action('View Order',route('orders.show', $this->order->id))
                    ->line('Thank you for shopping with us!');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'An order verification email has been sent.',
        ];
    }
}
