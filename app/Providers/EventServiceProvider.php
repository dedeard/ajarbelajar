<?php

namespace App\Providers;

use App\Events\CommentDeleted;
use App\Events\CommentedEpisodeEvent;
use App\Events\CommentLikedEvent;
use App\Events\CommentUnlikedEvent;
use App\Events\EpisodeUpdated;
use App\Events\EpisodeWatchedEvent;
use App\Events\LessonFavoritedEvent;
use App\Jobs\CommentedEpisodeNotificationJob;
use App\Jobs\EpisodeUpdatedJob;
use App\Jobs\EpisodeWatchedJob;
use App\Jobs\LessonFavoritedNotificationJob;
use App\Jobs\LikedCommentNotificationJob;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentLikedEvent::class => [
            LikedCommentNotificationJob::class,
        ],
        CommentUnlikedEvent::class => [],
        CommentedEpisodeEvent::class => [
            CommentedEpisodeNotificationJob::class,
        ],
        CommentDeleted::class => [],
        LessonFavoritedEvent::class => [
            LessonFavoritedNotificationJob::class,
        ],
        EpisodeWatchedEvent::class => [
            EpisodeWatchedJob::class,
        ],
        EpisodeUpdated::class => [
            EpisodeUpdatedJob::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
