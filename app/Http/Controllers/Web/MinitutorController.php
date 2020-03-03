<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Minitutor;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MinitutorController extends Controller
{
    public function index()
    {
        $minitutors = Minitutor::where('active', 1)->paginate(20);
        return view('web.minitutor.index', ['minitutors' => $minitutors]);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->first();
        if(!$user) return abort(404);
        if(!$user->minitutor) return abort(404);
        if(!$user->minitutor->active) return abort(404);

        $article = $user->articles()->select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', DB::raw('"article" as type'), ])->with(['user' => function($query){
            return $query->select(['id', 'username'])->with(['profile' => function($query){
                return $query->select(['user_id', 'first_name', 'last_name']);
            }]);
        }])->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->where('draf', false);

        $posts = $user->videos()->union($article)->select(['id', 'category_id', 'user_id', 'title', 'slug', 'hero', 'description', 'created_at', DB::raw('"video" as type')])->with(['user' => function($query){
            return $query->select(['id', 'username'])->with(['profile' => function($query){
                return $query->select(['user_id', 'first_name', 'last_name']);
            }]);
        }])->withCount(['comments' => function($query){
            return $query->where('approved', true);
        }, 'views'])->where('draf', false);

        return view('web.minitutor.show', ['user' => $user, 'posts' => $posts->paginate(12)]);
    }
}
