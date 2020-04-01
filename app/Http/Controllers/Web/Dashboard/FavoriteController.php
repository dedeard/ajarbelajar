<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Model\Post;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request->user()->favorites(Post::class)->where('draf', 0)->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->paginate(4);
        return view('web.dashboard.favorite.index', ['posts' => $posts]);
    }
}
