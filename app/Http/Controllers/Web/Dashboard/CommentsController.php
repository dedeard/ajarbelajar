<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $comments = $request->user()->postComments();
        $data['comments'] = $comments->select(['*'])->where('approved', 1)->with(['post' => function($q){
            $q->select(['id', 'title', 'slug', 'created_at', 'updated_at']);
        }, 'user' => function($q){
            $q->select('*');
        }])
        ->orderBy('post_comments.created_at', 'desc')
        ->paginate(15);
        return view('web.dashboard.comments.index', $data);
    }
}
