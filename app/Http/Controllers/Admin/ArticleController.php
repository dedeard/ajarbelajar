<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\Category;
use App\Model\RequestArticle;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    const driver = 'public';
    public function index()
    {
        $articles = Article::select(['id', 'user_id', 'title', 'draf', 'created_at'])->with(['user' => function($query){
            $query->select(['id', 'username'])->with(['profile' => function($query){
                $query->select(['id', 'user_id', 'first_name', 'last_name']);
            }]);
        }])->get();

        $data = [];

        foreach($articles as $article) {
            array_push($data, [
                'id' => $article->id,
                'user_id' => $article->user_id,
                'name' => $article->user->name(),
                'username' => $article->user->username,
                'title' => $article->title,
                'status' => $article->draf ? "Draf" : "Public",
                'created_at' => $article->created_at->format('Y/m/d')
            ]);
        }

        return view('admin.article.index', ['articles' => $data]);
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = Category::all();
        return view('admin.article.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'body' => 'nullable',
            'hero' => 'nullable|image|max:4000'
        ]);

        if(isset($data['hero'])) {
            if($article->hero) {
                if(Storage::disk(self::driver)->exists('article/hero/' . $article->hero)) {
                    Storage::disk(self::driver)->delete('article/hero/' . $article->hero);
                }
                if(Storage::disk(self::driver)->exists('article/hero/thumb/' . $article->hero)) {
                    Storage::disk(self::driver)->delete('article/hero/thumb/' . $article->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(720*1.5, 480*1.5, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(720/1.5, 480/1.5, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk(self::driver)->put('article/hero/' . $name, (string) $lg->encode('jpg', 90));
            Storage::disk(self::driver)->put('article/hero/thumb/' . $name, (string) $sm->encode('jpg', 90));

            $data['hero'] = $name;
        } else {
            unset($data['hero']);
        }

        $article->update($data);
        return redirect()->back()->withSuccess('Article berhasil di update.');
    }

    public function makePublic($id)
    {
        $article = Article::findOrFail($id);
        $article->draf = false;
        $article->save();
        return redirect()->back()->withSuccess("Artikel berhasil di publikasikan.");
    }

    public function makeDraf($id)
    {
        $article = Article::findOrFail($id);
        $article->draf = true;
        $article->save();
        return redirect()->back()->withSuccess("Artikel telah di jadikan draf");
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article->hero) {
            if(Storage::disk(self::driver)->exists('article/hero/' . $article->hero)) {
                Storage::disk(self::driver)->delete('article/hero/' . $article->hero);
            }
            if(Storage::disk(self::driver)->exists('article/hero/thumb/' . $article->hero)) {
                Storage::disk(self::driver)->delete('article/hero/thumb/' . $article->hero);
            }
        }
        $article->delete();
        return redirect()->route('admin.article.index')->withSuccess("Artikel telah dihapus.");
    }

    public function requested()
    {
        $articles = RequestArticle::select(['id', 'title', 'requested_at', 'user_id'])->with(['user' => function($query){
            $query->select('id','username');
        }])->whereNotNull('requested_at')->orderBy('requested_at', 'desc')->get();

        $data = [];

        foreach($articles as $article) {
            array_push($data, [
                'id' => $article->id,
                'user_id' => $article->user_id,
                'title' => $article->title,
                'username' => $article->user->username,
                'requested_at' => Carbon::parse($article->requested_at)->format('Y/m/d')
            ]);
        }
        return view('admin.article.requested', ['articles' => $data]);
    }

    public function rejectRequest($id)
    {
        $article = RequestArticle::whereNotNull('requested_at')->findOrFail($id);
        $article->requested_at = null;
        $article->save();
        return redirect()->route('admin.article.requested')->withSuccess('Permintaan Artikel telah di tolak.');
    }

    public function acceptRequest($id)
    {
        $article = RequestArticle::whereNotNull('requested_at')->findOrFail($id);
        if ($article->hero) {
            if(Storage::disk(self::driver)->exists('article/request/hero/' . $article->hero)) {
                Storage::disk(self::driver)->move('article/request/hero/' . $article->hero, 'article/hero/' . $article->hero);
            }
            if(Storage::disk(self::driver)->exists('article/request/hero/thumb/' . $article->hero)) {
                Storage::disk(self::driver)->move('article/request/hero/thumb/' . $article->hero, 'article/hero/thumb/' . $article->hero);
            }
        }
        $data = Article::create([
            'title' => $article->title,
            'hero' => $article->hero,
            'description' => $article->description,
            'category_id' => $article->category_id,
            'body' => $article->body,
            'user_id' => $article->user_id
        ]);
        $article->delete();
        return redirect()->route('admin.article.edit', $data->id)->withSuccess('Artikel minitutor telah diterima.');
    }

    public function showRequested($id)
    {
        $article = RequestArticle::whereNotNull('requested_at')->findOrFail($id);
        return view('admin.article.showRequested', ['article' => $article]);
    }
}
