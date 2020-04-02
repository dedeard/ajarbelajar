<?php

namespace App\Http\Controllers\Web\Dashboard;

use Artesaos\SEOTools\Facades\SEOTools;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Image as ModelImage;
use App\Model\RequestPost;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    const driver = 'public';
    public function index(Request $request)
    {
        $articles = $request->user()->requestPosts()
                                ->whereNull('requested_at')
                                ->where('type', 'article')
                                ->orderBy('updated_at', 'desc')
                                ->paginate(12);
        return view('web.dashboard.article.index', [ 'articles' => $articles ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([ 'title' => 'required|string|min:10|max:160' ]);
        $data['type'] = 'article';
        $article = new RequestPost($data);
        $request->user()->requestPosts()->save($article);
        return redirect()->route('dashboard.article.edit', $article->id);
    }

    public function edit(Request $request, $id)
    {
        $article = $request->user()
                            ->requestPosts()
                            ->whereNull('requested_at')
                            ->where('type', 'article')
                            ->findOrFail($id);
        SEOTools::setTitle($article->title);
        return view('web.dashboard.article.edit', ['article' => $article]);
    }

    public function update(Request $request, $id)
    {
        $article = $request->user()
                            ->requestPosts()
                            ->whereNull('requested_at')
                            ->where('type', 'article')
                            ->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category' => 'nullable|string|min:3|max:25',
            'body' => 'nullable|min:30',
            'hero' => 'nullable|image|max:4000',
            'tags' => 'nullable|string|max:150',
        ]);

        if(isset($data['hero'])) {
            if($article->hero) {
                if(Storage::disk(self::driver)->exists('post/hero/request/' . $article->hero)) {
                    Storage::disk(self::driver)->delete('post/hero/request/' . $article->hero);
                }
                if(Storage::disk(self::driver)->exists('post/hero/request/thumb/' . $article->hero)) {
                    Storage::disk(self::driver)->delete('post/hero/request/thumb/' . $article->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(720*1.5, 480*1.5, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(720/1.5, 480/1.5, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk(self::driver)->put('post/hero/request/' . $name, (string) $lg->encode('jpg', 90));
            Storage::disk(self::driver)->put('post/hero/request/thumb/' . $name, (string) $sm->encode('jpg', 90));

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
                if(Storage::disk(self::driver)->exists('post/image/' . $image->name)) {
                    Storage::disk(self::driver)->delete('post/image/' . $image->name);
                }
                $image->delete();
            }
        }

        return redirect()->back()->withSuccess('Artikel berhasil di update.');
    }

    public function destroy(Request $request, $id)
    {
        $article = $request->user()
                        ->requestPosts()
                        ->whereNull('requested_at')
                        ->where('type', 'article')
                        ->findOrFail($id);

        if($article->hero) {
            if(Storage::disk(self::driver)->exists('post/hero/request/' . $article->hero)) {
                Storage::disk(self::driver)->delete('post/hero/request/' . $article->hero);
            }
            if(Storage::disk(self::driver)->exists('post/hero/request/thumb/' . $article->hero)) {
                Storage::disk(self::driver)->delete('post/hero/request/thumb/' . $article->hero);
            }
        }
        foreach($article->images as $image) {
            if(Storage::disk(self::driver)->exists('post/image/' . $image->name)) {
                Storage::disk(self::driver)->delete('post/image/' . $image->name);
            }
            $image->delete();
        }
        $article->delete();
        return redirect()->back()->withSuccess('Artikel berhasil di hapus.');
    }

    public function image(Request $request, $id)
    {
        $article = $request->user()->requestPosts()->whereNull('requested_at')->where('type', 'article')->findOrFail($id);
        $data = $request->validate(['file' => 'required|image|max:4000']);
        $name = Str::random(60) . '.jpg';
        Storage::disk(self::driver)->put('post/image/' . $name, (string) Image::make($data['file'])->encode('jpg', 75));
        $article->images()->save(new ModelImage(['name' => $name]));
        return response()->json(['success' => 1, 'file' => ['url' => '/storage/post/image/' . $name]]);
    }
}
