<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostsResource;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Cache, DB;

class ArticlesController extends Controller
{
    public function index()
    {
        $minitutor = $request->user()->minitutor;
        $data =  Cache::remember('minitutor.'. $minitutor->id .'.articles', config('cache.age'), function () use ($minitutor){
            $articles = Article::postListQuery($minitutor->articles(), true)->get();
            return PostsResource::collection($articles);
        });
        return response()->json($data, 200);
    }

    public function show($slug)
    {
        $minitutor = $request->user()->minitutor;
        $data = Cache::remember('minitutor.'. $minitutor->id .'.articles.show.' . $slug, config('cache.age'), function () use ($slug, $minitutor) {
            $query = $minitutor->articles()->select('*', DB::raw("'Article' as type"));
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
            return ArticleResource::make($article);
        });
        return  response()->json($data, 200);
    }
}
