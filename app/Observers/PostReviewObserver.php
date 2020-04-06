<?php

namespace App\Observers;

use App\Model\PostReview;
use App\Notifications\ReviewToMinitutorPost;

class PostReviewObserver
{
    public function created(PostReview $postReview)
    {
        if($postReview->post->user->minitutor) {
            $rating = round(($postReview->understand + $postReview->inspiring + $postReview->language_style + $postReview->content_flow)/4);
            $postReview->post->user->minitutor->incrementPoint($rating*4);
            $postReview->post->user->notify(new ReviewToMinitutorPost($postReview));
        }
    }
}
