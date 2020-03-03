<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Comment;
use App\Model\Video;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $type, $id)
    {
        $data = $request->validate([
            'body' => 'required|string|min:3|max:600'
        ]);
        $user = $request->user();
        $data['user_id'] = $user->id;

        if($type == 'article') {
            $target = Article::where('draf', 0)->findOrFail($id);
        } elseif ($type == 'video') {
            $target = Video::where('draf', 0)->findOrFail($id);
        } else {
            return abort(404);
        }

        if($target->user->id === $user->id) {
            $data['approved'] = 1;
        } else {
            $data['approved'] = 0;
        }

        $comment = new Comment($data);
        $target->comments()->save($comment);

        return response()->json([
            'id' => $comment->id,
            'body' => $comment->body,
            'created_at' => $comment->created_at->diffForHumans(),
            'imageUrl' => $user->imageUrl(),
            'name' => $user->name(),
            'username' => $user->username,
        ], 200);
    }
    public function destroy(Request $request, $type, $target_id, $comment_id)
    {
        $user = $request->user();

        if($type == 'article') {
            $target = Article::where('draf', 0)->findOrFail($target_id);
        } elseif ($type == 'video') {
            $target = Video::where('draf', 0)->findOrFail($target_id);
        } else {
            return abort(404);
        }

        $comment = $target->comments()->findOrFail($comment_id);

        if($user->isAdmin() || $comment->user->id === $user->id) {
            $comment->delete();
            return response()->json([], 200);
        } else {
            return abort(403);
        }
    }
}
