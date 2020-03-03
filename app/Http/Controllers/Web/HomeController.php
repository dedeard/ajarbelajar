<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $popularArticles = Article::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', DB::raw('"article" as type'), ])->where('draf', 0)->withCount(['views', 'comments' => function($query){
            return $query->where('approved', true);
        }]);
        $populars = Video::union($popularArticles)->select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', DB::raw('"video" as type'), ])->where('draf', 0)->withCount(['views', 'comments' => function($query){
            return $query->where('approved', true);
        }])->orderBy('views_count', 'desc')->limit(3)->get();
        
        $newArticles = Article::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', DB::raw('"article" as type'), ])->where('draf', 0)->withCount(['views', 'comments' => function($query){
            return $query->where('approved', true);
        }])->orderBy('created_at', 'desc')->limit(3)->get();

        $newVideos = Video::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'created_at', DB::raw('"video" as type'), ])->where('draf', 0)->withCount(['views', 'comments' => function($query){
            return $query->where('approved', true);
        }])->orderBy('created_at', 'desc')->limit(3)->get();

        return view('web.home', ['populars' => $populars, 'newArticles' => $newArticles, 'newVideos' => $newVideos]);
    }

    public function article()
    {
        $articles = Article::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', DB::raw('"article" as type')])
            ->where('draf', 0)
            ->orderBy('created_at', 'desc')
            ->withCount(['comments' => function($query){
                return $query->where('approved', true);
            }, 'views'])
            ->paginate(12);
        return view('web.article', ['articles' => $articles]);
    }

    public function video()
    {
        $videos = Video::select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', DB::raw('"video" as type')])
        ->where('draf', 0)
        ->orderBy('created_at', 'desc')
        ->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])
        ->paginate(12);
        return view('web.video', ['videos' => $videos]);
    }
}
