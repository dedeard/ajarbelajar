<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CategoryHelper;
use App\Helpers\EditorjsHelper;
use App\Helpers\HeroHelper;
use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use App\Models\Minitutor;
use App\Notifications\MinitutorPostPublishedNotification;
use App\Notifications\NewPostNotification;
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
        SEOMeta::setTitle('Buat Artikel');
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

        PointHelper::onMinitutorPostCreated($minitutor->user);

        return redirect()->route('articles.edit', $article->id)->withSuccess('Artikel telah dibuat.');
    }

    public function edit($id)
    {
        SEOMeta::setTitle('Edit Artikel');
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
            $name = HeroHelper::generate($data['hero'], $article->hero ? $article->hero->name : null);
            $hero = $article->hero;
            if($hero) {
                $hero->update([
                    'type'=> 'hero',
                    'name'=> $name,
                    'original_name'=> $data['hero']->getClientOriginalName()
                ]);
            } else {
                $article->hero()->save(new Image([
                    'type'=> 'hero',
                    'name'=> $name,
                    'original_name'=> $data['hero']->getClientOriginalName()
                ]));
            }
        }
        unset($data['hero']);

        if (isset($data['category'])) {
            $data['category_id'] = Category::getCategoryOrCreate($data['category'])->id;
        } else {
            $data['category_id'] = null;
        }

        if(!$data['draf'] && $article->draf) {
            $article->minitutor->user->notify(new MinitutorPostPublishedNotification($article, 'article'));
            foreach($article->minitutor->subscribers()->get() as $user){
                $user->notify(new NewPostNotification($article, 'article'));
            }
        }

        $article->update($data);

        if(isset($data['body'])) EditorjsHelper::cleanImage($data['body'], $article->images);
        return redirect()->back()->withSuccess('Artikel telah diperbarui.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        foreach($article->subscriptions()->get() as $subscribe) {
            $subscribe->delete();
        }
        foreach($article->images as $image) {
            EditorjsHelper::deleteImage($image->name);
            $image->delete();
        }
        HeroHelper::destroy($article->hero ? $article->hero->name : null);
        $article->delete();
        return redirect()->route('articles.index')->withSuccess('Artikel berhasil dihapus.');
    }
}
