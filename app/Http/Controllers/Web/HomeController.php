<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Post;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{
    public function index()
    {
        SEOTools::setTitle(setting('seo.home.title'));
        SEOTools::setDescription(setting('seo.home.description'));

        $data = [];
        $data['populars'] = Post::posts()->orderBy('comments_count', 'desc')->limit(3)->get();
        $data['newArticles'] = Post::articles()->orderBy('created_at', 'desc')->limit(3)->get();
        $data['newVideos'] = Post::videos()->orderBy('created_at', 'desc')->limit(3)->get();

        return view('web.home', $data);
    }

    public function article()
    {
        SEOTools::setTitle(setting('seo.article.title'));
        SEOTools::setDescription(setting('seo.article.description'));

        $data = [];
        $data['articles'] = Post::articles()->orderBy('created_at', 'desc')->paginate(12);
        return view('web.article', $data);
    }

    public function video()
    {
        SEOTools::setTitle(setting('seo.video.title'));
        SEOTools::setDescription(setting('seo.video.description'));

        $data = [];
        $data['videos'] = Post::videos()->orderBy('created_at', 'desc')->paginate(12);
        return view('web.video', $data);
    }
}
