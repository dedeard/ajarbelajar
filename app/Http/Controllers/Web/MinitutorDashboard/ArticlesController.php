<?php

namespace App\Http\Controllers\Web\MinitutorDashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image as ModelImage;
use App\Models\RequestPost;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $articles = $request->user()->requestPosts()->where('type', 'article');
        $articles = $articles->exclude(['description', 'body']);
        $articles = $articles->with(['category']);
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $articles = $articles->where('title', 'like', $search);
        }
        $articles = $articles->orderBy('updated_at', 'desc');
        $articles = $articles->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor-dashboard.articles.index', [ 'articles' => $articles]);
    }

    public function publishToggle(Request $request, $id)
    {
        $article = $request->user()->requestPosts()->where('type', 'article')->findOrFail($id);
        if($article->requested_at) {
            $article->requested_at = null;
            $article->save();
            return redirect()->back()->withSuccess('Berhasil Membatalkan permintaan untuk mempublish Artikel.');
        } else {
            $article->requested_at = now();
            $article->save();
            return redirect()->back()->withSuccess('Terima kasih.. Artikel anda segera akan kami tinjau untuk di publikasikan.');
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([ 'title' => 'required|string|min:3|max:160' ]);
        $data['type'] = 'article';
        $article = new RequestPost($data);
        $request->user()->requestPosts()->save($article);
        return redirect()->route('dashboard.minitutor.articles.edit', $article->id);
    }

    public function create()
    {
        return view('web.minitutor-dashboard.articles.create');
    }

    public function edit(Request $request, $id)
    {
        $article = $request->user()->requestPosts()->where('type', 'article')->findOrFail($id);
        SEOTools::setTitle($article->title);
        return view('web.minitutor-dashboard.articles.edit', ['article' => $article]);
    }

    public function update(Request $request, $id)
    {
        $article = $request->user()->requestPosts()->where('type', 'article')->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|min:3|max:160',
            'description' => 'nullable|min:3|max:300',
            'category' => 'nullable|string|min:3|max:25',
            'body' => 'nullable|min:30',
            'hero' => 'nullable|image|max:4000',
            'tags' => 'nullable|string|max:150',
        ]);

        if(isset($data['hero'])) {
            if($article->hero) {
                if(Storage::disk('public')->exists('post/hero/request/' . $article->hero)) {
                    Storage::disk('public')->delete('post/hero/request/' . $article->hero);
                }
                if(Storage::disk('public')->exists('post/hero/request/thumb/' . $article->hero)) {
                    Storage::disk('public')->delete('post/hero/request/thumb/' . $article->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(config('image.hero.size.large.width'), config('image.hero.size.large.height'), function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(config('image.hero.size.thumb.width'), config('image.hero.size.thumb.height'), function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.' . config('image.hero.extension');

            Storage::disk('public')->put('post/hero/request/' . $name, (string) $lg->encode(config('image.hero.format'), config('image.hero.size.large.quality')));
            Storage::disk('public')->put('post/hero/request/thumb/' . $name, (string) $sm->encode(config('image.hero.format'), config('image.hero.size.thumb.quality')));

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
        if(isset($data['tags'])) $article->retag($data['tags']);

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

        if($request->publish === 'on'){
            $article->requested_at = now();
            $article->updated_at = now();
            $article->save();
        } else {
            $article->requested_at = null;
            $article->updated_at = now();
            $article->save();
        }
        return redirect()->back()->withSuccess('Artikel berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $article = $request->user()->requestPosts()->where('type', 'article')->findOrFail($id);

        if($article->hero) {
            if(Storage::disk('public')->exists('post/hero/request/' . $article->hero)) {
                Storage::disk('public')->delete('post/hero/request/' . $article->hero);
            }
            if(Storage::disk('public')->exists('post/hero/request/thumb/' . $article->hero)) {
                Storage::disk('public')->delete('post/hero/request/thumb/' . $article->hero);
            }
        }
        foreach($article->images as $image) {
            if(Storage::disk('public')->exists('post/image/' . $image->name)) {
                Storage::disk('public')->delete('post/image/' . $image->name);
            }
            $image->delete();
        }
        $article->delete();
        return redirect()->back()->withSuccess('Artikel berhasil dihapus.');
    }

    public function image(Request $request, $id)
    {
        $article = $request->user()->requestPosts()->where('type', 'article')->findOrFail($id);
        $data = $request->validate(['file' => 'required|image|max:4000']);
        $name = Str::random(60) . '.jpg';
        Storage::disk('public')->put('post/image/' . $name, (string) Image::make($data['file'])->encode('jpg', 75));
        $article->images()->save(new ModelImage(['name' => $name]));
        return response()->json(['success' => 1, 'file' => ['url' => '/storage/post/image/' . $name]]);
    }
}
