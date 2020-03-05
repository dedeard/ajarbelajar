<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Post;

class HomeController extends Controller
{
    public function index()
    {

        $populars = Post::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', 'type'])
                            ->where('draf', 0)
                            ->withCount(['views', 'comments' => function($query){
                                return $query->where('approved', true);
                            }])
                            ->orderBy('views_count', 'desc')
                            ->limit(3)
                            ->get();
        
        $newArticles = Post::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', 'type' ])
                        ->where('draf', 0)
                        ->where('type', 'article')
                        ->withCount(['views', 'comments' => function($query){
                            return $query->where('approved', true);
                        }])->orderBy('created_at', 'desc')
                        ->limit(3)
                        ->get();

        $newVideos = Post::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', 'type' ])
                        ->where('draf', 0)
                        ->where('type', 'video')
                        ->withCount(['views', 'comments' => function($query){
                            return $query->where('approved', true);
                        }])
                        ->orderBy('created_at', 'desc')
                        ->limit(3)
                        ->get();

        return view('web.home', ['populars' => $populars, 'newArticles' => $newArticles, 'newVideos' => $newVideos]);
    }

    public function article()
    {
        $articles = Post::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', 'type' ])
                            ->where('draf', 0)
                            ->where('type', 'article')
                            ->withCount(['views', 'comments' => function($query){
                                return $query->where('approved', true);
                            }])
                            ->orderBy('created_at', 'desc')
                            ->paginate(12);
        return view('web.article', ['articles' => $articles]);
    }

    public function video()
    {
        $videos = Post::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', 'type' ])
                        ->where('draf', 0)
                        ->where('type', 'video')
                        ->withCount(['views', 'comments' => function($query){
                            return $query->where('approved', true);
                        }])
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);
        return view('web.video', ['videos' => $videos]);
    }
}
