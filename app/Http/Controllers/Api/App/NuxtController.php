<?php

namespace App\Http\Controllers\Api\App;

use App\Models\Post;
use App\Models\User;
use App\Models\Minitutor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Cache;

class NuxtController extends Controller
{
    public function home()
    {
        $popularPosts = Cache::remember('popular.posts', config('cache.age'), function () {
            $posts = Post::postListQuery(Post::query())->withCount(['activities as view_count_week' => function($q){
                $q->whereBetween('updated_at', [
                    \carbon\Carbon::now()->subdays(7),
                    \carbon\Carbon::now()
                ]);
            }])->orderBy('view_count_week', 'desc')->limit(8)->get();
            return PostResource::collection($posts);
        });

        return [
            'popularPosts' => $popularPosts,
            'newVideos' => app(VideosController::class)->news(),
            'newArticles' => app(ArticlesController::class)->news(),
            'popularCategories' => app(CategoriesController::class)->popular(),
            'mostUserPoints' => app(UsersController::class)->mostPoints()
        ];
    }

    public function landing()
    {
        $counter = Cache::remember('nuxt.counter', config('cache.age'), function () {
            return [
                'article' => Post::where('type', 'article')->whereNotNull('posted_at')->count(),
                'video' => Post::where('type', 'video')->whereNotNull('posted_at')->count(),
                'user' => User::count(),
                'minitutor' => Minitutor::count(),
            ];
        });

        return [
            'counter' => $counter,
        ];
    }
}
