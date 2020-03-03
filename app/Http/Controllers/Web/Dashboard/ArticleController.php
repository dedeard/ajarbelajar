<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\RequestArticle;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    const driver = 'public';
    public function index(Request $request)
    {
        $articles = $request->user()->requestArticles()->whereNull('requested_at')->orderBy('updated_at', 'desc')->paginate(12);
        return view('web.dashboard.article.index', [ 'articles' => $articles ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([ 'title' => 'required|string|min:10|max:160' ]);
        $article = new RequestArticle($data);
        $request->user()->requestArticles()->save($article);
        return redirect()->route('dashboard.article.edit', $article->id);
    }

    public function edit(Request $request, $id)
    {
        $article = $request->user()->requestArticles()->whereNull('requested_at')->findOrFail($id);
        $categories = Category::all();
        return view('web.dashboard.article.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $article = $request->user()->requestArticles()->whereNull('requested_at')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'body' => 'nullable|min:30',
            'hero' => 'nullable|image|max:4000'
        ]);

        if(isset($data['hero'])) {
            if($article->hero) {
                if(Storage::disk(self::driver)->exists('article/request/hero/' . $article->hero)) {
                    Storage::disk(self::driver)->delete('article/request/hero/' . $article->hero);
                }
                if(Storage::disk(self::driver)->exists('article/request/hero/thumb/' . $article->hero)) {
                    Storage::disk(self::driver)->delete('article/request/hero/thumb/' . $article->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(720*1.5, 480*1.5, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(720/1.5, 480/1.5, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk(self::driver)->put('article/request/hero/' . $name, (string) $lg->encode('jpg', 90));
            Storage::disk(self::driver)->put('article/request/hero/thumb/' . $name, (string) $sm->encode('jpg', 90));

            $data['hero'] = $name;
        } else {
            unset($data['hero']);
        }

        $article->update($data);
        return redirect()->back()->withSuccess('Artikel berhasil di update.');
    }

    public function destroy(Request $request, $id)
    {
        $article = $request->user()->requestArticles()->whereNull('requested_at')->findOrFail($id);
        if($article->hero) {
            if(Storage::disk(self::driver)->exists('article/request/hero/' . $article->hero)) {
                Storage::disk(self::driver)->delete('article/request/hero/' . $article->hero);
            }
            if(Storage::disk(self::driver)->exists('article/request/hero/thumb/' . $article->hero)) {
                Storage::disk(self::driver)->delete('article/request/hero/thumb/' . $article->hero);
            }
        }
        $article->delete();
        return redirect()->back()->withSuccess('Artikel berhasil di hapus.');
    }
}
