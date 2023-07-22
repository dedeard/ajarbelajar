<?php

namespace App\Jobs;

use App\Events\CommentedEpisodeEvent;
use App\Notifications\EpisodeCommentedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CommentedEpisodeNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(CommentedEpisodeEvent $event): void
    {
        $event->comment->episode->lesson->user->notify(new EpisodeCommentedNotification($event->comment));
    }
}
