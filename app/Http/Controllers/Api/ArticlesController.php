<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostsResource;
use App\Http\Resources\ArticleResource;
use App\Jobs\AfterViewPostJob;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\LatesPostResource;
use Illuminate\Support\Facades\DB;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Cache::remember('articles.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            $articles = Article::postListQuery(Article::query())->orderBy('id', 'desc')->paginate(12);
            return PostsResource::collection($articles);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = Cache::remember('articles.show.' . $slug, config('cache.age'), function () use ($slug) {
            $query = Article::select('*', DB::raw("'Article' as type"));
            $query->with(['hero', 'category']);
            $query->with(['minitutor' => function($q) {
                $q->with('user');
            }]);
            $query->with(['comments' => function($q){
                $q->with(['user' => function($q){
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'points',
                        'username'
                    ]);
                }]);
                $q->where('public', true);
            }]);
            $query->withCount(['feedback as rating' => function($q){
                $q->select(DB::raw('coalesce(avg((understand + inspiring + language_style + content_flow)/4),0)'));
            }, 'feedback']);
            $query->whereHas('minitutor', function($q){
                $q->where('active', true);
            });

            $article = $query->where('slug', $slug)->firstOrFail();
            $latesPosts = $article->minitutor->latesPosts()->take(8)->get();

            return [
                'article' => ArticleResource::make($article),
                'latesPosts' => LatesPostResource::collection($latesPosts)
            ];
        });

        AfterViewPostJob::dispatchAfterResponse($data['article'], auth('api')->user());

        return $data;
    }

    public function popular()
    {
        return Cache::remember('articles.popular', config('cache.age'), function () {
            $articles = Article::postListQuery(Article::query())->orderBy('view_count', 'desc')->orderBy('id', 'desc')->limit(5)->get();
            return PostsResource::collection($articles);
        });
    }

    public function news()
    {
        return Cache::remember('articles.news', config('cache.age'), function () {
            $articles = Article::postListQuery(Article::query())->orderBy('id', 'desc')->limit(8)->get();
            return PostsResource::collection($articles);
        });
    }
}
