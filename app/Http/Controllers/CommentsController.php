<?php

namespace App\Http\Controllers;

use App\Events\CommentDeleted;
use App\Events\CommentedEpisodeEvent;
use App\Events\CommentLikedEvent;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Episode;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except('index');
    }

    public function index($episodeId)
    {
        $episode = Episode::whereHas('lesson', fn ($q)  => $q->where('public', true))->findOrFail($episodeId);
        $comments = $episode->comments()->listQuery(auth()->user())->orderBy('created_at', 'desc')->get();

        return response()->json(CommentResource::collection($comments));
    }

    public function store(Request $request, $episodeId)
    {
        $episode = Episode::whereHas('lesson', fn ($q)  => $q->where('public', true))->findOrFail($episodeId);
        $data = $request->validate(['body' => 'required|max:1500']);
        $comment = new Comment(['user_id' => $request->user()->id, 'body' => $data['body']]);
        $episode->comments()->save($comment);
        CommentedEpisodeEvent::dispatch($comment);

        $comment = Comment::listQuery(auth()->user())->find($comment->id);

        return response()->json(CommentResource::make($comment));
    }

    public function destroy(Request $request, $commentId)
    {
        $comment = $request->user()->comments()->findOrFail($commentId);
        $comment->delete();
        CommentDeleted::dispatch($comment->toArray());

        return response()->noContent();
    }

    public function likeToggle(Request $request, $commentId)
    {
        $user = $request->user();
        $comment = Comment::findOrFail($commentId);
        $liked = true;
        if ($comment->liked($user)) {
            $liked = false;
            $comment->unlike($user);
        } else {
            $comment->like($user);
        }

        return response()->json(['liked' => $liked]);
    }
}
