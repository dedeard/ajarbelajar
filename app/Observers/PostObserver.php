<?php

namespace App\Observers;

use App\Helpers\AddPoint;
use App\Jobs\CreateNewPostNotificationJob;
use App\Model\Post;
use App\Notifications\ApprovePost;
use App\Notifications\PostUpdated;

class PostObserver
{
    public function created(Post $post)
    {
        if(isset($post->user->minitutor)){
            $post->user->notify(new ApprovePost($post));
            AddPoint::onMinitutorPostCreated($post->user);
        }
    }

    public function updated(Post $post)
    {
        if(!$post->draf) {
            if($post->user->minitutor){
                $post->user->notify(new PostUpdated($post));
            }
        }

        if($post->draf !== $post->getOriginal('draf') && !$post->draf) {
            CreateNewPostNotificationJob::dispatch($post->id);
        }
    }
}
