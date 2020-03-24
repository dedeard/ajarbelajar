<?php

namespace App\Providers;

use App\Model\Post;
use App\Model\PostComment;
use App\Observers\PostCommentObserver;
use App\Observers\PostObserver;
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
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
