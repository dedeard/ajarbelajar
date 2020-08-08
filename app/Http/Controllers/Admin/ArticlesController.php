<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image as ModelImage;
use App\Models\Post;
use App\Models\RequestPost;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage post']);
    }
    public function index()
    {
        $articles = Post::select(['id', 'user_id', 'title', 'draf', 'created_at', 'updated_at'])
                    ->where('type', 'article')
                    ->with(['user' => function($query){
                        $query->select(['id', 'username', 'first_name', 'last_name']);
                    }])
                    ->paginate(20);

        return view('admin.article.index', ['articles' => $articles ]);
    }

    public function edit($id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $categories = Category::all();
        return view('admin.article.edit', ['article' => $article, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category' => 'nullable|string|min:3|max:25',
            'body' => 'nullable',
            'hero' => 'nullable|image|max:4000',
            'tags' => 'nullable|string|max:150',
        ]);

        if(isset($data['hero'])) {
            if($article->hero) {
                if(Storage::disk('public')->exists('post/hero/' . $article->hero)) {
                    Storage::disk('public')->delete('post/hero/' . $article->hero);
                }
                if(Storage::disk('public')->exists('post/hero/thumb/' . $article->hero)) {
                    Storage::disk('public')->delete('post/hero/thumb/' . $article->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(config('image.hero.size.large.width'), config('image.hero.size.large.height'), function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(config('image.hero.size.thumb.width'), config('image.hero.size.thumb.height'), function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.' . config('image.hero.extension');

            Storage::disk('public')->put('post/hero/' . $name, (string) $lg->encode(config('image.hero.format'), config('image.hero.size.large.quality')));
            Storage::disk('public')->put('post/hero/thumb/' . $name, (string) $sm->encode(config('image.hero.format'), config('image.hero.size.thumb.quality')));

            $data['hero'] = $name;
        } else {
            unset($data['hero']);
        }

        if(isset($data['category'])){
            $category = Category::where('slug', Str::slug($data['category'], '-'));
            if($category->exists()) {
                $category = $category->first();
            } else {
                $category = Category::create([
                    'name' => $data['category'],
                    'slug' => Str::slug($data['category'], '-')
                ]);
            }
            $data['category_id'] = $category->id;
        } else {
            $data['category_id'] = null;
        }

        $article->update($data);
        $article->retag($data['tags']);

        $body = json_decode($data['body']);
        $images = $article->images;

        foreach($images as $image) {
            $exists = false;
            foreach ($body->blocks as $block) {
                if($block->type === 'image'){
                    if($block->data->file->url === '/storage/post/image/' . $image->name) $exists = true;
                }
            }
            if(!$exists) {
                if(Storage::disk('public')->exists('post/image/' . $image->name)) {
                    Storage::disk('public')->delete('post/image/' . $image->name);
                }
                $image->delete();
            }
        }

        return redirect()->back()->withSuccess('Article berhasil di update.');
    }

    public function makePublic($id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $article->draf = false;
        $article->save();
        return redirect()->back()->withSuccess("Artikel berhasil di publikasikan.");
    }

    public function makeDraf($id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $article->draf = true;
        $article->save();
        return redirect()->back()->withSuccess("Artikel telah di jadikan draf");
    }

    public function destroy($id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        if ($article->hero) {
            if(Storage::disk('public')->exists('post/hero/' . $article->hero)) {
                Storage::disk('public')->delete('post/hero/' . $article->hero);
            }
            if(Storage::disk('public')->exists('post/hero/thumb/' . $article->hero)) {
                Storage::disk('public')->delete('post/hero/thumb/' . $article->hero);
            }
        }
        foreach($article->images as $image) {
            if(Storage::disk('public')->exists('post/image/' . $image->name)) {
                Storage::disk('public')->delete('post/image/' . $image->name);
            }
            $image->delete();
        }
        $article->delete();
        return redirect()->route('admin.articles.index')->withSuccess("Artikel telah dihapus.");
    }

    public function requested()
    {
        $articles = RequestPost::select(['id', 'type', 'title', 'requested_at', 'user_id'])
                                ->where('type', 'article')
                                ->with(['user' => function($query){
                                    $query->select('id','username');
                                }])->whereNotNull('requested_at')->orderBy('requested_at', 'desc')->get();

        return view('admin.article.requested', ['articles' => $articles]);
    }

    public function rejectRequest($id)
    {
        $article = RequestPost::whereNotNull('requested_at')->where('type', 'article')->findOrFail($id);
        $article->requested_at = null;
        $article->save();
        return redirect()->route('admin.articles.requested')->withSuccess('Permintaan Artikel telah di tolak.');
    }

    public function acceptRequest($id)
    {
        $article = RequestPost::whereNotNull('requested_at')->where('type', 'article')->findOrFail($id);

        if ($article->hero) {
            if(Storage::disk('public')->exists('post/hero/request/' . $article->hero)) {
                Storage::disk('public')->move('post/hero/request/' . $article->hero, 'post/hero/' . $article->hero);
            }
            if(Storage::disk('public')->exists('post/hero/request/thumb/' . $article->hero)) {
                Storage::disk('public')->move('post/hero/request/thumb/' . $article->hero, 'post/hero/thumb/' . $article->hero);
            }
        }

        $post = Post::create([
            'type' => $article->type,
            'title' => $article->title,
            'hero' => $article->hero,
            'description' => $article->description,
            'category_id' => $article->category_id,
            'body' => $article->body,
            'user_id' => $article->user_id
        ]);

        $tags = [];
        foreach($article->tags as $tag) array_push($tags, $tag->name);
        $post->retag($tags);
        foreach($article->images as $image) {
            $post->images()->save(new ModelImage(['name' => $image->name]));
            $image->delete();
        }
        $article->delete();
        return redirect()->route('admin.articles.edit', $post->id)->withSuccess('Artikel minitutor telah diterima.');
    }

    public function showRequested($id)
    {
        $article = RequestPost::whereNotNull('requested_at')->where('type', 'article')->findOrFail($id);
        return view('admin.article.showRequested', ['article' => $article]);
    }

    public function image(Request $request, $id)
    {
        $article = Post::where('type', 'article')->findOrFail($id);
        $data = $request->validate(['file' => 'required|image|max:4000']);
        $name = Str::random(60) . '.jpg';
        Storage::disk('public')->put('post/image/' . $name, (string) Image::make($data['file'])->encode('jpg', 75));
        $article->images()->save(new ModelImage(['name' => $name]));
        return response()->json(['success' => 1, 'file' => ['url' => '/storage/post/image/' . $name]]);
    }
}
