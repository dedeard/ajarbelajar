<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ArticleResource;
use App\Http\Resources\Api\LatesPostResource;
use App\Http\Resources\Api\PostsResource;
use App\Jobs\AfterViewPostJob;
use App\Models\Article;
use Cache;
use DB;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        return Cache::remember('articles.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            $articles = Article::postListQuery(Article::query())->orderBy('id', 'desc')->paginate(12);
            return PostsResource::collection($articles);
        });
    }

    public function show($slug)
    {
        $data = Cache::remember('articles.show.' . $slug, config('cache.age'), function () use ($slug) {
            $query = Article::select('*', DB::raw("'Article' as type"));
            $query->with(['hero', 'category']);
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
            $latesPosts = $article->minitutor->latesPosts()->take(8)->get();
            return [
                'article' => ArticleResource::make($article),
                'latesPosts' => LatesPostResource::collection($latesPosts),
            ];
        });
        AfterViewPostJob::dispatchAfterResponse($data['article'], auth('api')->user());
        return $data;
    }
}
