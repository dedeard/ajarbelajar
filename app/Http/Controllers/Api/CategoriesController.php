<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostsResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Playlist;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Cache::remember('categories', config('cache.age'), function () {
            return Category::withCount([
                'articles' => function($q){
                    $q->where('draf', false);
                },
                'playlists' => function($q){
                    $q->where('draf', false);
                },
            ])
            ->having('articles_count', '>', 0)
            ->orHaving('playlists_count', '>', 0)
            ->orderByRaw('articles_count + playlists_count DESC')
            ->orderBy('id')
            ->get();
        });
        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return Cache::remember('categories.show.' . $id, config('cache.age'), function () use ($id) {
            if(is_numeric($id)) {
                $category = Category::findOrFail($id);
            } else {
                $category = Category::where('slug', $id)->firstOrFail();
            }
            $posts = Playlist::postListQuery($category->playlists())
                ->unionAll(Article::postListQuery($category->articles()))
                ->orderBy('created_at', 'desc')
                ->get();
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'data' => PostsResource::collection($posts),
            ];
        });
    }

    public function popular() {
        $categories = Cache::remember('categories.popular', config('cache.age'), function () {
            return Category::withCount([
                'articles' => function($q){
                    $q->where('draf', false);
                },
                'playlists' => function($q){
                    $q->where('draf', false);
                },
            ])
            ->having('articles_count', '>', 0)
            ->orHaving('playlists_count', '>', 0)
            ->orderByRaw('articles_count + playlists_count DESC')
            ->orderBy('id')
            ->limit(8)
            ->get();
        });
        return CategoryResource::collection($categories);
    }
}
