<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Playlist;
use App\Notifications\ApproveCommentNotification;
use App\Notifications\CommentToMinitutorPostNotification;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage commet']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Daftar Komentar');
        $comments = Comment::orderBy('id', 'desc')->paginate(25);
        return view('comments.index', ['comments' => $comments]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        if($comment->type === 'article') {
            $post = Article::findOrFail($comment->commentable_id);
        } else {
            $post = Playlist::findOrFail($comment->commentable_id);
        }
        PointHelper::onCommentAccepted($comment->user);
        PointHelper::onMinitutorPostCommentAccepted($post->minitutor->user);
        $comment->user->notify(new ApproveCommentNotification($comment, $post));
        $post->minitutor->user->notify(new CommentToMinitutorPostNotification($comment, $post));
        return redirect()->back()->withSuccess('Komentar telah dipublikasikan.');
    }
}
