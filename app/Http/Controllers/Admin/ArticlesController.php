<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CategoryHelper;
use App\Helpers\EditorjsHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Minitutor;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage article');
    }

    public function index(Request $request)
    {
        SEOMeta::setTitle('Daftar Artikel');
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $articles = Article::where('title', 'like', $search);
            $articles->orWhere('description', 'like', $search);
        } else {
            $articles = Article::query();
        }
        $articles = $articles->orderBy('id', 'desc')->paginate(20)->appends(['search' => $request->input('search')]);
        return view('articles.index', ['articles' => $articles]);
    }

    public function minitutors(Request $request)
    {
        SEOMeta::setTitle('Pilih Minitutor untuk artikel baru');
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $minitutors = Minitutor::whereHas('user', function ($q) use ($search) {
                return $q->where('name', 'like', $search)
                    ->orWhere('username', 'like', $search)
                    ->orWhere('email', 'like', $search);
            })->where('active', true)->orderBy('id', 'desc');
        } else {
            $minitutors = Minitutor::where('active', true)->orderBy('id', 'desc');
        }
        $minitutors = $minitutors->paginate(20)->appends(['search' => $request->input('search')]);
        return view('articles.minitutors', ['minitutors' => $minitutors]);
    }

    public function create(Request $request)
    {
        $minitutor = Minitutor::where('active', true)->findOrFail($request->input('id') ?? 0);
        return view('articles.create', ['minitutor' => $minitutor]);
    }

    public function store(Request $request)
    {
        $minitutor = Minitutor::where('active', true)->findOrFail($request->input('id') ?? 0);

        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable'
        ]);

        $article = new Article($data);
        $minitutor->articles()->save($article);

        return redirect()->route('articles.edit', $article->id)->withSuccess('Berhasil membuat artikel baru.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
            'category' => 'nullable|string',
            'hero' => 'nullable|image|max:4000',
            'body' => 'nullable',
        ]);

        $data['draf'] = (bool) !$request->input('public');

        if (isset($data['hero'])) {
            $data['hero'] = HeroHelper::generate($data['hero'], $article->hero);
        } else {
            unset($data['hero']);
        }

        if (isset($data['category'])) {
            $data['category_id'] = CategoryHelper::getCategoryIdOrCreate($data['category']);
        } else {
            $data['category_id'] = null;
        }

        $article->update($data);

        if(isset($data['body'])) EditorjsHelper::cleanImage($data['body'], $article->images);
        return redirect()->back()->withSuccess('Artikel berhasil di update.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        foreach($article->images as $image) {
            EditorjsHelper::deleteImage($image->name);
            $image->delete();
        }
        HeroHelper::destroy($article->hero);
        $article->delete();
        return redirect()->route('articles.index')->withSuccess('Artikel berhasil dihapus.');
    }
}
