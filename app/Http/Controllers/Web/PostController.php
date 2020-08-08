<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\PostComment;
use App\Models\Post;
use App\Models\PostReview;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function show(Request $request, $slug)
    {
        $posts = Post::where('draf', 0)
            ->where('slug', $slug)
            ->with(['comments' => function($query) use($request) {
                $query->where('approved', 1)->orderBy('created_at', 'desc');
            }, 'reviews' => function($q){
                return $q->select(['post_id', DB::raw('(understand + inspiring + language_style + content_flow)/4 as rating')]);
            }])
            ->withCount(['views'=> function($q){
                $q->select(DB::raw('count(distinct(ip))'));
            }]);

        if(!$posts->exists()) return abort(404);

        $post = $posts->first();

        $rating = null;

        if($request->user()) {
            $rating = $post->reviews()->where('user_id', Auth::user()->id);
            $rating = ($rating->exists()) ? $rating->first() : null;
            Activity::createUserActivity($request->user(), $post);
            $post->views()->save(PostView::createViewLog($request));
        }

        $description = null;
        $body = $post->body ? json_decode($post->body) : null;
        if($body && isset($body->blocks)) {

            foreach ($body->blocks as $block) {
                if(!$description && $block->type === 'paragraph' && strlen($block->data->text) > 30){
                    $description = substr($block->data->text, 0, 160);
                }
            }
        }

        $keywords = [];
        foreach($post->tags as $tag) array_push($keywords, $tag->name);

        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->description ?? $description);
        SEOMeta::addMeta('article:published_time', $post->created_at->toW3CString(), 'property');
        if($post->category) SEOMeta::addMeta('article:section', $post->category->name, 'property');
        SEOMeta::addKeyword($keywords);

        OpenGraph::setDescription($post->description ?? $description);
        OpenGraph::setTitle($post->title);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'id-ID');

        OpenGraph::addImage($post->heroUrl());

        JsonLd::setTitle($post->title);
        JsonLd::setDescription($post->description ?? $description);
        JsonLd::setType('Article');

        if($post->images) {
            $img_urls = [];
            foreach($post->images as $img) {
                array_push($img_urls, ['url' => asset('/storage/post/image/' . $img->name)]);
            }
            JsonLd::addImage($img_urls);
        }

        return view('web.post.show', ['post' => $post, 'review' => $rating ]);
    }

    public function storeComment(Request $request, $id)
    {
        $data = $request->validate([ 'body' => 'required|string|min:3|max:600' ]);
        $data['user_id'] = $request->user()->id;
        $data['approved'] = 0;
        $post = Post::where('draf', 0)->findOrFail($id);
        $comment = new PostComment($data);
        $post->comments()->save($comment);
        return redirect()->back()->withSuccess('Komentar kamu telah terkirim dan akan segera terbit.');
    }

    public function storeReview(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validate([
            'message' => 'required|string|min:3|max:600',
            'understand' => 'required|numeric|digits_between:1,5',
            'inspiring' => 'required|numeric|digits_between:1,5',
            'language_style' => 'required|numeric|digits_between:1,5',
            'content_flow' => 'required|numeric|digits_between:1,5',
        ]);
        $q = $post->reviews()->where('user_id', Auth::user()->id);

        if($request->sync_with_me && $request->sync_with_me === 'on'){
            $data['sync_with_me'] = 1;
        } else {
            $data['sync_with_me'] = 0;
        }

        if($q->exists()) {
            $q->first()->update($data);
        } else {
            PostReview::create([
                'user_id' => $request->user()->id,
                'post_id' => $id,
                'message' => $data['message'],
                'understand' => $data['understand'],
                'inspiring' => $data['inspiring'],
                'language_style' => $data['language_style'],
                'content_flow' => $data['content_flow'],
                'sync_with_me' => $data['sync_with_me'],
            ]);
        }
        return redirect()->back()->withSuccess('Terima kasih atas feedback kamu.');
    }
}
