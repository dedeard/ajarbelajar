<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentToMinitutorPostNotification extends Notification
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
            'type' => $this->post->type,
            'message' => $this->comment->user->name . " telah mengomentari " . $this->post->type . " anda."
        ];
    }
}
