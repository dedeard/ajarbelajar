<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EditorjsHelper;
use App\Helpers\HeroHelper;
use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Image;
use App\models\RequestArticle;
use Artesaos\SEOTools\Facades\SEOMeta;

class RequestArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage article');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('Daftar Artikel Permintaan');
        $articles = RequestArticle::where('requested_at', '!=', null);
        $articles = $articles->orderBy('id', 'desc')->paginate(20);
        return view('request_articles.index', ['articles' => $articles]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = RequestArticle::where('requested_at', '!=', null)->findOrFail($id);
        SEOMeta::setTitle($article->title);
        return view('request_articles.show', ['article' => $article, 'body' => EditorjsHelper::compile($article->body)]);
    }

    /**
     * Accept the article.
     */
    public function accept($id)
    {
        $rArticle = RequestArticle::where('requested_at', '!=', null)->findOrFail($id);
        $minitutor = $rArticle->minitutor;

        $data = [
            'title' => $rArticle->title,
            'description' => $rArticle->description,
            'body' => $rArticle->body,
        ];
        if($rArticle->category) $data['category_id'] = $rArticle->category->id;

        $article = new Article($data);
        $minitutor->articles()->save($article);

        if  ($rArticle->hero) {
            $hero = new Image([
                'type' => 'hero',
                'original_name' => $rArticle->hero->original_name,
                'name' => $rArticle->hero->name,
            ]);
            $rArticle->hero->delete();
            $article->hero()->save($hero);
        }

        foreach($rArticle->images as $oldImage) {
            $image = new Image([
                'type' => 'image',
                'original_name' => $oldImage->original_name,
                'name' => $oldImage->name,
            ]);
            $oldImage->delete();
            $article->images()->save($image);
        }

        $rArticle->delete();
        PointHelper::onMinitutorPostCreated($minitutor->user);
        return redirect()->route('articles.edit', $article->id)->withSuccess('Artikel telah diterima.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = RequestArticle::where('requested_at', '!=', null)->findOrFail($id);
        foreach($article->images as $image) {
            EditorjsHelper::deleteImage($image->name);
            $image->delete();
        }
        HeroHelper::destroy($article->hero ? $article->hero->name : null);
        $article->delete();
        return redirect()->route('request-articles.index')->withSuccess('Artikel permintaan telah dihapus.');
    }
}
