<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\PostComment;
use App\Model\Post;
use App\Model\PostView;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function article(Request $request, $slug)
    {
        $articles = Post::where('draf', 0)->where('slug', $slug)->with(['comments' => function($query) use($request) {
            if ($request->user() && $request->user()->isAdmin()) {
                $query->orderBy('created_at', 'desc');
            } else{
                $query->where('approved', 1)->orderBy('created_at', 'desc');
            }
        }])->withCount('views');
        if(!$articles->exists()) {
            return abort(404);
        }
        $article = $articles->first();
        $article->views()->save(PostView::createViewLog($request));
        return view('web.post.article', ['article' => $article]);
    }

    public function video(Request $request, $slug)
    {
        $videos = Post::where('draf', 0)
                ->where('type', 'video')
                ->where('slug', $slug)
                ->with(['comments' => function($query) use($request) {
                    if ($request->user() && $request->user()->isAdmin()) {
                        return $query->orderBy('created_at', 'desc');
                    } else{
                        return $query->where('approved', 1)->orderBy('created_at', 'desc');
                    }
                }])
                ->withCount('views');
        if(!$videos->exists()) {
            return abort(404);
        }
        $video = $videos->first();
        $video->views()->save(PostView::createViewLog($request));
        return view('web.post.video', ['video' => $video]);
    }

    public function storeComment(Request $request, $type, $id)
    {
        $data = $request->validate([
            'body' => 'required|string|min:3|max:600'
        ]);
        $user = $request->user();
        $data['user_id'] = $user->id;

        $target = Post::where('draf', 0)->findOrFail($id);

        if($target->user->id === $user->id || $user->isAdmin()) {
            $data['approved'] = 1;
        } else {
            $data['approved'] = 0;
        }

        $comment = new PostComment($data);
        $target->comments()->save($comment);
        return redirect()->back()->withSuccess('Komentar kamu telah terkirim dan akan segera terbit.');
    }

    public function approveComment($type, $id, $comment_id)
    {
        $target = Post::findOrFail($id);
        $comment = $target->comments()->findOrFail($comment_id);
        $comment->approved = true;
        $comment->save();

        return redirect()->back()->withSuccess('Komentar telah di terima.');
    }

    public function destroyComment($type, $id, $comment_id)
    {
        if($type == 'article') {
            $target = Post::findOrFail($id);
        } elseif ($type == 'video') {
            $target = Post::findOrFail($id);
        } else {
            return abort(404);
        }

        $comment = $target->comments()->findOrFail($comment_id);
        $comment->delete();

        return redirect()->back()->withSuccess('Komentar telah di hapus.');
    }
}
