<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


    class FeedbackStatusChanged extends Notification
    {
        use Queueable;

        protected $feedback;
        protected $status;
        protected $customMessage; // Optional custom message

        /**
         * Create a new notification instance.
         */
        public function __construct($feedback, $status, $customMessage = null)
        {
            $this->feedback = $feedback;
            $this->status = $status;
            $this->customMessage = $customMessage;
        }

        /**
         * Get the notification's delivery channels.
         */
        public function via($notifiable)
        {
            return ['database']; // You can also include 'mail' if you want both email and database notifications
        }

        /**
         * Get the mail representation of the notification.
         */
        public function toMail($notifiable)
        {
            $message = (new MailMessage)
                        ->subject('Your Feedback Status Has Been Updated')
                        ->line('The status of your feedback titled "' . $this->feedback->title . '" has changed to: ' . $this->status);

            if ($this->customMessage) {
                $message->line($this->customMessage);
            }

            $message->action('View Feedback', url('/feedbacks/' . $this->feedback->id))
                    ->line('Thank you for being an active member of our community!');

            return $message;
        }

        /**
         * Get the array representation of the notification for database storage.
         */
        public function toArray($notifiable)
        {
            return [
                'feedback_id' => $this->feedback->id,
                'feedback_title' => $this->feedback->title,
                'status' => $this->status,
                'message' => $this->customMessage ?? 'Your feedback status has been updated.',
                'url' => url('/feedbacks/' . $this->feedback->id),
            ];
        }
    }


