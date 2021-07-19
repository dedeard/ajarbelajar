<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Cache;

class CategoriesController extends Controller
{
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
            // ->having('articles_count', '>', 0)
            // ->orHaving('playlists_count', '>', 0)
            ->orderByRaw('articles_count + playlists_count DESC')
            ->orderBy('id')
            ->get();
        });
        return response()->json($categories, 200);
    }
}
