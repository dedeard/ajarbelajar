<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\CoverHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab') ?? 'all';
        abort_unless(in_array($tab, ['all', 'public', 'draft']), 404);

        $user = $request->user();
        $query = $user->articles()->orderBy('updated_at', 'desc');

        switch ($tab) {
            case 'public':
                $query->where('public', true);
                break;
            case 'draft':
                $query->where('public', false);
                break;
        }

        $articles = $query->paginate(10);
        return view('dashboard.articles.index', ['articles' => $articles, 'tab' => $tab]);
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('dashboard.articles.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:250',
            'category' => 'required|exists:categories,id',
            'description' => 'required|max:300',
        ]);
        $data['category_id'] = $data['category'];
        $article = new Article($data);
        $request->user()->articles()->save($article);
        return redirect()->route('dashboard.articles.edit', $article->id)->withSuccess('Berhasil membuat artikel baru.');
    }

    public function edit(Request $request, $id)
    {
        $tab = $request->input('tab');
        abort_unless(in_array($tab ?? 'info', ['info', 'cover', 'content']), 404);
        $article = $request->user()->articles()->findOrFail($id);
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        return view('dashboard.articles.edit', ['categories' => $categories, 'article' => $article, 'tab' => $tab ?? 'info']);
    }

    public function destroy(Request $request, $id)
    {
        $article = $request->user()->articles()->findOrFail($id);
        CoverHelper::destroy($article->cover);
        $article->delete();
        return redirect()->route('dashboard.articles.index')->withSuccess('Berhasil menghapus artikel.');
    }

    public function update(Request $request, $id)
    {
        $article = $request->user()->articles()->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|max:250',
            'category' => 'required|exists:categories,id',
        ]);
        $public = $request->get('public');

        $data['public'] = false;
        if (isset($public) && $public === 'on') $data['public'] = true;

        if ($data['public'] && !$article->posted_at) {
            $data['posted_at'] = now();
            $article->update($data);
            // event(new ArticlePublished($this->article));
        } else {
            $article->update($data);
        }
        return response()->json([
            'message' => 'Artikel berhasil diperbarui',
        ]);
    }

    public function updateCover(Request $request, $id)
    {
        $article = $request->user()->articles()->findOrFail($id);
        $data = $request->validate([
            'image' => 'required|image|max:4000'
        ]);

        $name = CoverHelper::generate($data['image'], $article->cover);
        $article->update(['cover' => $name]);

        return response()->json($article->cover_url);
    }

    public function updateContent(Request $request, $id)
    {
        $article = $request->user()->articles()->findOrFail($id);
        $data = $request->validate(['content' => 'required|max:3000']);
        $article->update($data);
        return response()->noContent();
    }
}
