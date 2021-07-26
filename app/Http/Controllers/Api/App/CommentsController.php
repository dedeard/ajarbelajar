<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request, $post_id)
    {
        $user = $request->user();
        $target = Post::whereNotNull('posted_at')->findOrFail($post_id);

        $data = $request->validate(['body' => 'required|string|min:10|max:300']);

        $data['user_id'] = $user->id;
        $comment = new Comment($data);
        $target->comments()->save($comment);

        return response()->noContent();
    }
}
