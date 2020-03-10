<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\PostComment;
use App\Model\Post;
use App\Model\PostReview;
use App\Model\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show(Request $request, $slug)
    {
        $posts = Post::where('draf', 0)->where('slug', $slug)->with(['comments' => function($query) use($request) {
            if ($request->user() && $request->user()->isAdmin()) {
                $query->orderBy('created_at', 'desc');
            } else{
                $query->where('approved', 1)->orderBy('created_at', 'desc');
            }
        }])->withCount('views');
        if(!$posts->exists()) {
            return abort(404);
        }
        $post = $posts->first();
        $post->views()->save(PostView::createViewLog($request));

        $rating = null;

        if($request->user()) {
            $rating = $post->reviews()->where('user_id', Auth::user()->id);
            $rating = ($rating->exists()) ? $rating->first() : null; 
        }

        return view('web.post.show', ['post' => $post, 'review' => $rating ]);
    }

    public function storeComment(Request $request, $id)
    {
        $data = $request->validate([
            'body' => 'required|string|min:3|max:600'
        ]);
        $user = $request->user();
        $data['user_id'] = $user->id;

        $post = Post::where('draf', 0)->findOrFail($id);

        if($post->user->id === $user->id || $user->isAdmin()) {
            $data['approved'] = 1;
        } else {
            $data['approved'] = 0;
        }

        $comment = new PostComment($data);
        $post->comments()->save($comment);
        return redirect()->back()->withSuccess('Komentar kamu telah terkirim dan akan segera terbit.');
    }

    public function approveComment($id, $comment_id)
    {
        $post = Post::findOrFail($id);
        $comment = $post->comments()->findOrFail($comment_id);
        $comment->approved = true;
        $comment->save();

        return redirect()->back()->withSuccess('Komentar telah di terima.');
    }

    public function destroyComment($id, $comment_id)
    {
        $post = Post::findOrFail($id);
        $comment = $post->comments()->findOrFail($comment_id);
        $comment->delete();
        return redirect()->back()->withSuccess('Komentar telah di hapus.');
    }

    public function storeReview(Request $request, $post_id)
    {
        $post = Post::findOrFail($post_id);
        $data = $request->validate([
            'body' => 'required|string|min:3|max:600',
            'rating' => 'required|numeric|digits_between:1,5'
        ]);
        $q = $post->reviews()->where('user_id', Auth::user()->id);
        if($q->exists()) {
            $q->first()->update($data);
        } else {
            PostReview::create([
                'user_id' => $request->user()->id,
                'post_id' => $post_id,
                'body' => $data['body'],
                'rating' => $data['rating'],
            ]);
        }
        return redirect()->back()->withSuccess('Terima kasih atas review kamu.');
    }
}
