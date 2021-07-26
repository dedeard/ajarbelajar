<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Notifications\ApproveCommentNotification;
use App\Notifications\CommentToMinitutorPostNotification;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage commet']);
    }

    public function index()
    {
        $comments = Comment::orderBy('id', 'desc')->paginate(25);
        return view('comments.index', ['comments' => $comments]);
    }

    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return redirect()->back()->withSuccess('Komentar telah dihapus.');
    }

    /**
     * make comment public.
     */
    public function makePublic($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['public' => true]);
        $post = $comment->post;
        PointHelper::onCommentAccepted($comment->user);
        PointHelper::onMinitutorPostCommentAccepted($post->minitutor->user);
        $comment->user->notify(new ApproveCommentNotification($comment, $post));
        $post->minitutor->user->notify(new CommentToMinitutorPostNotification($comment, $post));
        return redirect()->back()->withSuccess('Komentar telah dipublikasikan.');
    }
}
