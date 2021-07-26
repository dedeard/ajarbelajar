<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EditorjsHelper;
use App\Helpers\HeroHelper;
use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Image;
use App\Models\RequestPost;

class RequestArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage article');
    }

    public function index()
    {
        $articles = RequestPost::where('requested_at', '!=', null)->where('type', 'article');
        $articles = $articles->orderBy('id', 'desc')->paginate(20);
        return view('request_articles.index', ['articles' => $articles]);
    }

    public function show($id)
    {
        $article = RequestPost::where('requested_at', '!=', null)->where('type', 'article')->findOrFail($id);
        return view('request_articles.show', ['article' => $article, 'body' => EditorjsHelper::compile($article->body)]);
    }

    public function accept($id)
    {
        $rArticle = RequestPost::where('requested_at', '!=', null)->where('type', 'article')->findOrFail($id);
        $minitutor = $rArticle->minitutor;

        $data = [
            'type' => 'article',
            'title' => $rArticle->title,
            'hero' => $rArticle->hero,
            'description' => $rArticle->description,
            'body' => $rArticle->body,
        ];
        if($rArticle->category) $data['category_id'] = $rArticle->category->id;

        $article = new Post($data);
        $minitutor->posts()->save($article);

        foreach($rArticle->images as $oldImage) {
            $image = new Image([
                'name' => $oldImage->name,
            ]);
            $oldImage->delete();
            $article->images()->save($image);
        }

        $rArticle->delete();
        PointHelper::onMinitutorPostCreated($minitutor->user);
        return redirect()->route('articles.edit', $article->id)->withSuccess('Artikel telah diterima.');
    }

    public function destroy($id)
    {
        $article = RequestPost::where('requested_at', '!=', null)->where('type', 'article')->findOrFail($id);
        foreach($article->images as $image) {
            EditorjsHelper::deleteImage($image->name);
            $image->delete();
        }
        HeroHelper::destroy($article->hero);
        $article->delete();
        return redirect()->route('request-articles.index')->withSuccess('Artikel permintaan telah dihapus.');
    }
}
