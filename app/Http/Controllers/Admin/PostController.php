<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $userq = function($q){
            return $q->select(['id', 'first_name', 'last_name', 'email', 'username'])
            ->with(['minitutor' => function($q){
                return $q->select(['id', 'user_id', 'contact']);
            }]);
        };
        $posts = Post::select(['id', 'title', 'user_id', 'slug'])
                    ->with(['user' => $userq])
                    ->orderBy('id')
                    ->paginate(20);

        return view('admin.posts.index', ['posts' => $posts]);
    }

    public function articles()
    {
        $userq = function($q){
            return $q->select(['id', 'first_name', 'last_name', 'email', 'username'])
            ->with(['minitutor' => function($q){
                return $q->select(['id', 'user_id', 'contact']);
            }]);
        };
        $posts = Post::select(['id', 'title', 'user_id', 'slug'])->where('type', 'article')
                    ->with(['user' => $userq])
                    ->orderBy('id')
                    ->paginate(20);

        return view('admin.posts.article', ['posts' => $posts]);
    }

    public function videos()
    {
        $userq = function($q){
            return $q->select(['id', 'first_name', 'last_name', 'email', 'username'])
            ->with(['minitutor' => function($q){
                return $q->select(['id', 'user_id', 'contact']);
            }]);
        };
        $posts = Post::select(['id', 'title', 'user_id', 'slug'])->where('type', 'video')
                    ->with(['user' => $userq])
                    ->orderBy('id')
                    ->paginate(20);

        return view('admin.posts.video', ['posts' => $posts]);
    }
}
