<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Playlist;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    public function index(Request $request, $type, $id)
    {
        $target = null;
        if($type === 'article') {
            $target = Article::where('draf', false)->findOrFail($id);
        } else if ($type === 'playlist') {
            $target = Playlist::where('draf', false)->findOrFail($id);
        }
        if (!$target) return abort(404);
        $limit = $request->input('limit');
        if (empty($limit) || ($limit > 15)) {
            $limit = 15;
        }
        $comments = $target->comments()->where('public', true)->orderBy('id')->paginate($limit);
        $comments->getCollection()->transform(function ($value) {
            return CommentResource::make($value);
        });
        return response()->json($comments, 200);
    }

    public function store(Request $request, $type, $id)
    {
        $target = null;
        if($type === 'article') {
            $target = Article::where('draf', false)->findOrFail($id);
        } else if ($type === 'playlist') {
            $target = Playlist::where('draf', false)->findOrFail($id);
        }
        if (!$target) return abort(404);

        $user = $request->user();
        $data = $request->validate(['body' => 'required|string|min:10|max:300']);

        $data['user_id'] = $user->id;
        $comment = new Comment($data);
        $target->comments()->save($comment);

        return response()->json([], 200);
    }
}
