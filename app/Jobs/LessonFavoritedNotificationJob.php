<?php

namespace App\Jobs;

use App\Events\LessonFavoritedEvent;
use App\Notifications\LessonFavoritedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LessonFavoritedNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param  LessonFavoritedEvent  $event
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LessonFavoritedEvent $event)
    {
        $notifications = $event->lesson->user->notifications()
            ->where('type', LessonFavoritedNotification::class)
            ->where('data->lesson_id', $event->lesson->id)
            ->where('data->user_id', $event->user->id)
            ->exists();

        if (! $notifications) {
            $event->lesson->user->notify(new LessonFavoritedNotification($event->lesson, $event->user));
        }
    }
}
