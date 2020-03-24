<?php

namespace App\Observers;

use App\Jobs\CreateNewPostNotificationJob;
use App\Model\Post;

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param  \App\Model\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        //
    }

    /**
     * Handle the post "updated" event.
     *
     * @param  \App\Model\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        if($post->draf !== $post->getOriginal('draf') && !$post->draf) {
            CreateNewPostNotificationJob::dispatch($post->id);
        }
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param  \App\Model\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the post "restored" event.
     *
     * @param  \App\Model\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param  \App\Model\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
