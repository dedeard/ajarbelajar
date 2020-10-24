<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Playlist;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
        $data['type'] = $type;

        $data['user_id'] = $user->id;
        $comment = new Comment($data);
        $target->comments()->save($comment);

        return response()->json([], 200);
    }
}
