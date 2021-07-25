<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CategoryHelper;
use App\Helpers\EditorjsHelper;
use App\Helpers\HeroHelper;
use App\Helpers\PointHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Image;
use App\Models\Minitutor;
use App\Notifications\MinitutorPostPublishedNotification;
use App\Notifications\NewPostNotification;
use Exception;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage article');
    }

    public function index(Request $request)
    {
        if (!empty($request->input('search'))) {
            $search = '%' . $request->input('search') . '%';
            $articles = Post::where('type', 'article')->where('title', 'like', $search);
        } else {
            $articles = Post::where('type', 'article');
        }
        $articles = $articles->orderBy('id', 'desc')->paginate(20)->appends(['search' => $request->input('search')]);
        return view('articles.index', ['articles' => $articles]);
    }

    public function minitutors(Request $request)
    {
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

        $data['type'] = 'article';
        $article = new Post($data);
        $minitutor->posts()->save($article);

        PointHelper::onMinitutorPostCreated($minitutor->user);

        return redirect()->route('articles.edit', $article->id)->withSuccess('Artikel telah dibuat.');
    }

    public function edit($id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $categories = Category::all();
        return view('articles.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function uploadImage(Request $request, $id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $data = $request->validate(['file' => 'required|image|max:4000']);
        $upload = EditorjsHelper::uploadImage($data['file']);
        $article->images()->save(new Image([
            'name' => $upload['name'],
            'type' => "image"
        ]));
        return response()->json(['success' => 1, 'file' => $upload]);
    }

    public function update(Request $request, $id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
            'category' => 'nullable|string',
            'hero' => 'nullable|image|max:4000',
            'body' => 'nullable',
        ]);

        if (isset($data['hero'])) {
            $data['hero'] = HeroHelper::generate($data['hero'], $article->hero);
        } else {
            unset($data['hero']);
        }

        if (isset($data['category'])) {
            $data['category_id'] = Category::getCategoryOrCreate($data['category'])->id;
        } else {
            $data['category_id'] = null;
        }
        unset($data['category']);

        $public = (bool) $request->input('public');

        if(!$public && $article->posted_at) {
            $data['posted_at'] = null;
        }

        if($public && !$article->posted_at) {
            $data['posted_at'] = now();

            $article->minitutor->user->notify(new MinitutorPostPublishedNotification($article));
            foreach($article->minitutor->followers()->get() as $follower){
                try {
                    $follower->user->notify(new NewPostNotification($article));
                } catch(Exception $e) {
                    continue;
                }
            }
        }

        $article->update($data);

        if(isset($data['body'])) EditorjsHelper::cleanImage($data['body'], $article->images);
        return redirect()->back()->withSuccess('Artikel telah diperbarui.');
    }

    public function destroy($id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        foreach($article->images as $image) {
            EditorjsHelper::deleteImage($image->name);
            $image->delete();
        }
        HeroHelper::destroy($article->hero);
        $article->delete();
        return redirect()->route('articles.index')->withSuccess('Artikel berhasil dihapus.');
    }
}
