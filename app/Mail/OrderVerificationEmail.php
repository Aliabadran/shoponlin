<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class OrderVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $user;
    public $order;
    public $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $order)
    {
        // $verificationUrl
        $this->user = $user;
        $this->order = $order;
     // $this->verificationUrl = $verificationUrl;
        //$this->verificationUrl = route('order.verify', ['order' => $order->id, 'hash' => sha1($order->id)]);
    }



    public function build()
    {
        $verificationUrl = route('order.verify', ['order' => $this->order->id, 'hash' => sha1($this->order->id)]);
        return $this->subject('Verify Your Order')
            ->view('emails.order-verification')  // The email template
           // ->text('emails.order_verification_plain') // For plain text emails
            ->with([
                'user' => $this->user,
                'order' => $this->order,
                'url' => $verificationUrl,
               // 'orderDate' => $this->order->created_at,
                //'orderId' => $this->order->id,
                //'orderTotal' => $this->order->total,

            ]);

         
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Verification Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: '',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }


}
