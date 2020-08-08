<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use App\Models\Post;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;

class MinitutorController extends Controller
{
    public function index(Request $request)
    {
        $minitutors = Minitutor::where('active', 1);
        $minitutors->withCount(['posts' => function($q){
            return $q->where('draf', 0);
        }]);
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $minitutors = $minitutors->whereHas('user', function($q) use($search) {
                return $q->select('*')->where('first_name', 'like', $search)->orWhere('last_name', 'like', $search)->orWhere('username', 'like', $search);
            });
        }
        $minitutors->orderBy('posts_count', 'desc')->orderBy('id', 'asc');
        $minitutors = $minitutors->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor', ['minitutors' => $minitutors]);
    }

    private function getMinitutor($username) : Minitutor {
        return Minitutor::whereHas('user', function($q) use($username){
            $q->where('username', $username);
        })->where('active', 1)->firstorfail();
    }

    public function info($username)
    {
        $minitutor = $this->getMinitutor($username);
        SEOTools::setTitle('Info Minitutor ' . $minitutor->user->name());
        SEOTools::setDescription($minitutor->user->about);
        return view('web.minitutor.info', ['minitutor' => $minitutor ]);
    }

    public function videos(Request $request, $username){
        $minitutor = $this->getMinitutor($username);
        $videos = Post::videos($minitutor->user);
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $videos = $videos->where('title', 'like', $search);
        }
        $videos = $videos->orderBy('created_at', 'desc')->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor.videos', ['videos' => $videos, 'minitutor' => $minitutor]);
    }

    public function articles(Request $request, $username){
        $minitutor = $this->getMinitutor($username);
        $articles = Post::articles($minitutor->user);
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $articles = $articles->where('title', 'like', $search);
        }
        $articles = $articles->orderBy('created_at', 'desc')->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor.articles', ['articles' => $articles, 'minitutor' => $minitutor]);
    }

    public function followers(Request $request, $username)
    {
        $minitutor = $this->getMinitutor($username);
        $users = $minitutor->subscribers();
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $users = $users->where('first_name', 'like', $search)->orWhere('last_name', 'like', $search)->orWhere('username', 'like', $search);
        }
        $users = $users->orderBy('pivot_created_at', 'desc')->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor.followers', ['users' => $users, 'minitutor' => $minitutor]);
    }
}
