<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmedNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Order Confirmation')
                    ->greeting('Hello, ' . $notifiable->name)
                    ->line('Your order has been confirmed.')
                    ->line('Order ID: ' . $this->order->id)
                    ->line('Total: $' . $this->order->total)
                    ->action('View Order', route('orders.show', $this->order->id))
                    ->line('Thank you for your purchase!');

                }


    // Optionally, you can define database notifications or SMS notifications
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total,
            'message' => 'Your order has been confirmed.',
        ];
    }
}




