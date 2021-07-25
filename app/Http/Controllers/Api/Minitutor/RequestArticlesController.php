<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Helpers\EditorjsHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestArticleResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\RequestPost;
use Illuminate\Http\Request;

class RequestArticlesController extends Controller
{
    public function index(Request $request)
    {
        $minitutor = $request->user()->minitutor;
        $articles = $minitutor->requestPosts()->with(['category'])->where('type', 'article')->orderBy('updated_at', 'desc')->get();
        return response()->json(RequestArticleResource::collection($articles), 200);
    }

    public function show(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $article = $minitutor->requestPosts()->with(['category'])->where('type', 'article')->findOrFail($id);
        return response()->json(RequestArticleResource::make($article), 200);
    }

    public function store(Request $request)
    {
        $minitutor = $request->user()->minitutor;
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable|string',
        ]);
        $data['type'] = 'article';
        $article = new RequestPost($data);
        $minitutor->requestPosts()->save($article);
        return response()->json(['id' => $article->id], 200);
    }

    public function update(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $article = $minitutor->requestPosts()->where('type', 'article')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
            'category' => 'nullable|string',
            'body' => 'nullable',
        ]);
        if (isset($data['category'])) {
            $data['category_id'] = Category::getCategoryOrCreate($data['category'])->id;
            unset($data['category']);
        } else {
            $data['category_id'] = null;
        }
        $article->update($data);
        if (isset($data['body'])) {
            EditorjsHelper::cleanImage($data['body'], $article->images);
        }

        if (!$request->input('requested') && $article->requested_at) {
            $article->requested_at = null;
            $article->save();
        } elseif ($request->input('requested') && !$article->requested_at) {
            $article->requested_at = now();
            $article->save();
        }

        return response()->json(RequestArticleResource::make($article), 200);
    }

    public function updateHero(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $article = $minitutor->requestPosts()->where('type', 'article')->findOrFail($id);

        $data = $request->validate(['hero' => 'image|max:4000']);
        $name = HeroHelper::generate($data['hero'], $article->hero);

        $article->hero = $name;
        $article->save();

        return response()->json(HeroHelper::getUrl($name), 200);
    }

    public function uploadImage(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $article = $minitutor->requestPosts()->where('type', 'article')->findOrFail($id);

        $data = $request->validate(['file' => 'required|image|max:4000']);
        $upload = EditorjsHelper::uploadImage($data['file']);
        $article->images()->save(new Image([
            'name' => $upload['name']
        ]));

        return response()->json(['success' => 1, 'file' => $upload]);
    }

    public function destroy(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $article = $minitutor->requestPosts()->where('type', 'article')->findOrFail($id);

        foreach ($article->images as $image) {
            EditorjsHelper::deleteImage($image->name);
            $image->delete();
        }

        HeroHelper::destroy($article->hero);
        $article->delete();
        return response()->noContent();
    }
}
