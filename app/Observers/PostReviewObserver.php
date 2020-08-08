<?php

namespace App\Observers;

use App\Helpers\AddPoint;
use App\Models\PostReview;
use App\Notifications\ReviewToMinitutorPost;

class PostReviewObserver
{
    public function created(PostReview $postReview)
    {
        if($postReview->post->user->minitutor) {
            $rating = round(($postReview->understand + $postReview->inspiring + $postReview->language_style + $postReview->content_flow)/4);
            AddPoint::onReviewed($postReview->user);
            AddPoint::onMinitutorPostReviewed($postReview->post->user, $rating);
            $postReview->post->user->notify(new ReviewToMinitutorPost($postReview));
        }
    }
}
