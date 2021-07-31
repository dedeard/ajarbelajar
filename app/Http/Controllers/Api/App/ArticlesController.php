<?php

namespace App\Http\Controllers\Api\App;

use App\Jobs\AfterViewPostJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\ArticleResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Cache, DB;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        return Cache::remember('articles.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            $articles = Post::postListQuery(Post::where('type', 'article'))->orderBy('id', 'desc')->paginate(12);
            return PostResource::collection($articles);
        });
    }

    public function show($slug)
    {
        $data = Cache::remember('articles.show.' . $slug, config('cache.age'), function () use ($slug) {
            $query = Post::whereNotNull('posted_at')->where('type', 'article');
            $query->with(['category']);
            $query->with(['minitutor' => function ($q) {
                $q->with(['user' => function ($q) {
                    $q->select([ 'id', 'name', 'avatar', 'points', 'username' ]);
                }]);
            }]);
            $query->with(['comments' => function ($q) {
                $q->with(['user' => function ($q) {
                    $q->select([ 'id', 'name', 'avatar', 'points', 'username' ]);
                }]);
                $q->where('public', true);
            }]);
            $query->withCount(['feedback as rating' => function ($q) {
                $q->select(DB::raw('coalesce(avg((understand + inspiring + language_style + content_flow)/4),0)'));
            }, 'feedback']);
            $query->whereHas('minitutor', function ($q) {
                $q->where('active', true);
            });
            $article = $query->where('slug', $slug)->firstOrFail();

            $latesPosts = $article->minitutor
                ->posts()
                ->whereNotNull('posted_at')
                ->where('id', '!=', $article->id)
                ->take(8)
                ->get()
                ->map(function($item){
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'posted_at' => $item->posted_at,
                ];
            });

            return [
                'article' => ArticleResource::make($article),
                'latesPosts' => $latesPosts,
            ];
        });
        AfterViewPostJob::dispatchAfterResponse($data['article'], auth('api')->user());
        return $data;
    }

    public function news()
    {
        $articles = Cache::remember('articles.news', config('cache.age'), function () {
            $articles = Post::postListQuery(Post::where('type', 'article'))->orderBy('posted_at', 'desc')->limit(8)->get();
            return PostResource::collection($articles);
        });
        return $articles;
    }
}
