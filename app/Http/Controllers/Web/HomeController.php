<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $posts = Post::posts()->where('title', 'like', $search)
                                  ->orWhere('description', 'like', $search)
                                  ->paginate(12)
                                  ->appends(['search' => $request->input('search')]);
            return view('web.search', ['posts' => $posts]);
        } else {
            return view('web.home');
        }
    }

    public function article()
    {
        $data = [];
        $data['articles'] = Post::articles()->orderBy('created_at', 'desc')->paginate(12);
        return view('web.article', $data);
    }

    public function video()
    {
        $data = [];
        $data['videos'] = Post::videos()->orderBy('created_at', 'desc')->paginate(12);
        return view('web.video', $data);
    }

    public function faq()
    {
        return view('web.faq');
    }

    public function constructiveFeedback()
    {
        return view('web.constructive_feedback');
    }
}
