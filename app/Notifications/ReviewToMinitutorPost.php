<?php

namespace App\Notifications;

use App\Model\PostReview;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReviewToMinitutorPost extends Notification
{
    use Queueable;

    private $postReview = null;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PostReview $postReview)
    {
        $this->postReview = $postReview;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Anda memiliki 1 feedback baru dari ' . $this->postReview->user->name())
                    ->line('Hi ' . $this->postReview->post->user->name() . ', Anda memiliki 1 feedback baru dari ' . $this->postReview->user->name())
                    ->action('Lihat Feedback', url('/dashboard/minitutor/reviews'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'review_id' => $this->postReview->id
        ];
    }
}
