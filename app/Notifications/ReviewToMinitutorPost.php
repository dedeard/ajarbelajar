<?php

namespace App\Notifications;

use App\Model\PostReview;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

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
        return ['database', 'broadcast'];
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
