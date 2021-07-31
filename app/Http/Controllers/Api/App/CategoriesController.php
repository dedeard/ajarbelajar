<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Cache;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('categories', config('cache.age'), function () {
            return Category::whereHas('posts', function ($q) {
                $q->whereNotNull('posted_at');
            })
            ->orderBy('name')
            ->get();
        });
        return response()->json($categories, 200);
    }

    public function show($slug)
    {
        return Cache::remember('categories.show.' . $slug, config('cache.age'), function () use ($slug) {
            $category = Category::where('slug', $slug)->firstOrFail();
            $posts = Post::postListQuery($category->posts())->orderBy('posted_at', 'desc')->paginate(12);
            return PostResource::collection($posts);
        });
    }

    public function popular()
    {
        $categories = Cache::remember('categories.popular', config('cache.age'), function () {
            return Category::whereHas('posts', function ($q) {
                $q->whereNotNull('posted_at');
            })
            ->withCount([
                'posts as post_count' => function($q){
                    $q->whereNotNull('posted_at');
                }
            ])
            ->orderBy('post_count', 'desc')
            ->limit(8)
            ->get();
        });
        return $categories;
    }
}
