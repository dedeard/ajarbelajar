<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApproveCommentNotification extends Notification
{
    use Queueable;

    public $comment = null, $post = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
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
            'comment_id' => $this->comment->id,
            'type' => $this->comment->type,
            'message' => "Komentar anda pada ". $this->comment->type ." dari MiniTutor '" . $this->post->minitutor->user->name . "' telah diterima."
        ];
    }
}
