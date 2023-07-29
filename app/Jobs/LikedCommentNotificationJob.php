<?php

namespace App\Jobs;

use App\Events\CommentLikedEvent;
use App\Notifications\CommentLikedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LikedCommentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(CommentLikedEvent $event): void
    {
        // Check if the notification already exists before sending it
        $exists = $event->comment->user->notifications()
            ->where('type', CommentLikedNotification::class)
            ->where('data->comment_id', $event->comment->id)
            ->where('data->user_id', $event->user->id)
            ->exists();

        if (! $exists) {
            $event->comment->user->notify(new CommentLikedNotification($event->comment, $event->user));
        }
    }
}
