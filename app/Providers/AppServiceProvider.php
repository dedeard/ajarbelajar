<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostReview;
use App\Observers\PostCommentObserver;
use App\Observers\PostObserver;
use App\Observers\PostReviewObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        PostComment::observe(PostCommentObserver::class);
        PostReview::observe(PostReviewObserver::class);
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
