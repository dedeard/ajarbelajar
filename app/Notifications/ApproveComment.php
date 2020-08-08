<?php

namespace App\Notifications;

use App\Models\PostComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApproveComment extends Notification
{
    use Queueable;

    private $comment, $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PostComment $comment)
    {
        $this->post = $comment->post;
        $this->comment = $comment;
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
            'post_id' => $this->post->id,
            'comment_id' => $this->comment->id
        ];
    }
}
