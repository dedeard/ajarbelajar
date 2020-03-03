<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function article(Request $request)
    {
        $articles = $request->user()->favorites(Article::class)->select(['*', DB::raw('"article" as type')])->where('draf', 0)->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->paginate(4);
        return view('web.dashboard.favorite.article', ['articles' => $articles]);
    }
    public function video(Request $request)
    {
        $videos = $request->user()->favorites(Video::class)->select(['*', DB::raw('"video" as type')])->where('draf', 0)->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->paginate(4);
        return view('web.dashboard.favorite.video', ['videos' => $videos]);
    }
}
