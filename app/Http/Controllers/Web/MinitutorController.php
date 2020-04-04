<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\Post;
use App\Model\User;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\DB;

class MinitutorController extends Controller
{
    public function index()
    {
        $minitutors = Minitutor::where('active', 1)->withCount(['posts' => function($q){
            return $q->where('draf', 0);
        }])->orderBy('posts_count', 'desc')->paginate(18);
        return view('web.minitutor.index', ['minitutors' => $minitutors]);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->first();
        
        if(!$user) return abort(404);
        if(!$user->minitutor) return abort(404);
        if(!$user->minitutor->active) return abort(404);

        SEOTools::setTitle('Minitutor ' . $user->name());
        SEOTools::setDescription($user->about);

        $posts = Post::postType($user->posts());

        return view('web.minitutor.show', ['user' => $user, 'posts' => $posts->paginate(12)]);
    }
}
