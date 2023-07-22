<?php

namespace App\Http\Controllers;

use App\Events\CommentDeleted;
use App\Events\CommentedEpisodeEvent;
use App\Helpers\EditorjsHelper;
use App\Models\Comment;
use App\Models\Episode;
use App\Notifications\EpisodeCommentedNotification;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function store(Request $request, $episodeId)
    {
        $episode = Episode::whereHas('lesson', function ($q) {
            $q->where('public', true);
        })->orderBy('name', 'asc')->findOrFail($episodeId);
        $body = $request->input('body');
        $request->merge(['body' => EditorjsHelper::compile($body)]);
        $request->validate(['body' => 'required|max:1500']);
        $comment = new Comment(['user_id' => $request->user()->id, 'body' => $body]);
        $episode->comments()->save($comment);
        CommentedEpisodeEvent::dispatch($comment);
        return response()->noContent();
    }

    public function destroy(Request $request, $commentId)
    {
        $comment = $request->user()->comments()->findOrFail($commentId);
        $comment->delete();
        CommentDeleted::dispatch($comment->toArray());
        return response()->noContent();
    }
}
