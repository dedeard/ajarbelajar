<?php

namespace App\Observers;

use App\Helpers\AddPoint;
use App\Model\PostComment;
use App\Notifications\ApproveComment;
use App\Notifications\CommentToMinitutorPost;

class PostCommentObserver
{
    public function updated(PostComment $postComment)
    {
        if($postComment->approved !== $postComment->getOriginal('approved') && $postComment->approved === 1) {
            AddPoint::onCommentAccepted($postComment->user);
            AddPoint::onMinitutorPostCommentAccepted($postComment->post->user);
            $postComment->user->notify(new ApproveComment($postComment));
            if(isset($postComment->post->user->minitutor)) {
                $postComment->post->user->notify(new CommentToMinitutorPost($postComment));
            }
        }
    }
}
