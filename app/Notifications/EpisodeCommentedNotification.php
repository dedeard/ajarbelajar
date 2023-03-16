<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Episode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EpisodeCommentedNotification extends Notification
{
    use Queueable;

    public $comment = null;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'comment_id' => $this->comment->id,
            'message' => $this->comment->user->name . " telah mengomentari video anda."
        ];
    }
}
