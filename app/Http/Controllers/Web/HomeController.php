<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Model\Post;

class HomeController extends Controller
{
    public function index()
    {
        Seo::set('Home');
        $data = [];
        $data['populars'] = Post::posts()->orderBy('comments_count', 'desc')->limit(3)->get();
        $data['newArticles'] = Post::articles()->orderBy('created_at', 'desc')->limit(3)->get();
        $data['newVideos'] = Post::videos()->orderBy('created_at', 'desc')->limit(3)->get();

        return view('web.home', $data);
    }

    public function article()
    {
        Seo::set('Article');
        $data = [];
        $data['articles'] = Post::articles()->orderBy('created_at', 'desc')->paginate(12);
        return view('web.article', $data);
    }

    public function video()
    {
        Seo::set('Video');
        $data = [];
        $data['videos'] = Post::videos()->orderBy('created_at', 'desc')->paginate(12);
        return view('web.video', $data);
    }
}
