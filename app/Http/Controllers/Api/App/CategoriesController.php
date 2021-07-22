<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostsResource;
use App\Models\Category;
use App\Models\Article;
use App\Models\Playlist;
use Cache;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('categories', config('cache.age'), function () {
            return Category::withCount([
                'articles' => function ($q) {
                    $q->where('draf', false);
                },
                'playlists' => function ($q) {
                    $q->where('draf', false);
                },
            ])
                ->having('articles_count', '>', 0)
                ->orHaving('playlists_count', '>', 0)
                ->orderByRaw('articles_count + playlists_count DESC')
                ->orderBy('id')
                ->get();
        });
        return response()->json($categories, 200);
    }

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
}
