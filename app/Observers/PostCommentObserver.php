<?php

namespace App\Observers;

use App\Model\PostComment;
use App\Notifications\ApproveComment;
use App\Notifications\CommentToMinitutorPost;

class PostCommentObserver
{
    /**
     * Handle the post comment "created" event.
     *
     * @param  \App\Model\PostComment  $postComment
     * @return void
     */
    public function created(PostComment $postComment)
    {
        //
    }

    /**
     * Handle the post comment "updated" event.
     *
     * @param  \App\Model\PostComment  $postComment
     * @return void
     */
    public function updated(PostComment $postComment)
    {
        if($postComment->approved !== $postComment->getOriginal('approved') && $postComment->approved === 1) {
            $postComment->user->notify(new ApproveComment($postComment));
            if(isset($postComment->post->user->minitutor)) {
                $postComment->post->user->minitutor->incrementPoint(4);
                $postComment->post->user->notify(new CommentToMinitutorPost($postComment));
            }
        }
    }

    /**
     * Handle the post comment "deleted" event.
     *
     * @param  \App\Model\PostComment  $postComment
     * @return void
     */
    public function deleted(PostComment $postComment)
    {
        //
    }

    /**
     * Handle the post comment "restored" event.
     *
     * @param  \App\Model\PostComment  $postComment
     * @return void
     */
    public function restored(PostComment $postComment)
    {
        //
    }

    /**
     * Handle the post comment "force deleted" event.
     *
     * @param  \App\Model\PostComment  $postComment
     * @return void
     */
    public function forceDeleted(PostComment $postComment)
    {
        //
    }
}
