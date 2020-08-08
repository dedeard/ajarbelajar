<?php

namespace App\Http\Controllers\Web\MinitutorDashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcceptedController extends Controller
{
    public function index(Request $request)
    {
        $accepteds = Post::postType($request->user()->posts(), null, null);
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $accepteds = $accepteds->where('title', 'like', $search)->orWhere('description', 'like', $search);
        }
        $accepteds = $accepteds->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor-dashboard.accepted.index', ['accepteds' => $accepteds]);
    }

    public function preview(Request $request, $slug)
    {
        $post = $request->user()->posts()->where('slug', $slug);
        if(!$post->exists()) return abort(404);


        $review = function($q){
            return $q->select(['*', DB::raw('(understand + inspiring + language_style + content_flow)/4 as rating')])->with(['user' => function($q){
                return $q->select(['id', 'first_name', 'last_name', 'username', 'avatar']);
            }])->orderBy('created_at', 'desc');
        };

        $post = $post->with(['reviews' => $review])->withCount(['views'=> function($q){
            $q->select(DB::raw('count(distinct(ip))'));
        }]);
        return view('web.minitutor-dashboard.accepted.preview', ['post' => $post->first()]);
    }
}
