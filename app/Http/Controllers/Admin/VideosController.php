<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Image as ModelImage;
use App\Model\Post;
use App\Model\RequestPost;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['can:manage post']);
    }

    public function index()
    {
        $videos = Post::select(['id', 'user_id', 'title', 'draf', 'created_at', 'updated_at'])
        ->where('type', 'video')
        ->with(['user' => function($query){
            $query->select(['id', 'username', 'first_name', 'last_name']);
        }])
        ->paginate(20);

        return view('admin.video.index', ['videos' => $videos ]);
    }


    public function edit($id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $categories = Category::all();
        return view('admin.video.edit', ['video' => $video, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category' => 'nullable|string|min:3|max:25',
            'body' => 'nullable',
            'hero' => 'nullable|image|max:4000',
            'tags' => 'nullable|string|max:150',
        ]);

        if(isset($data['hero'])) {
            if($video->hero) {
                if(Storage::disk('public')->exists('post/hero/' . $video->hero)) {
                    Storage::disk('public')->delete('post/hero/' . $video->hero);
                }
                if(Storage::disk('public')->exists('post/hero/thumb/' . $video->hero)) {
                    Storage::disk('public')->delete('post/hero/thumb/' . $video->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(1280, 720, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(640, 360, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk('public')->put('post/hero/' . $name, (string) $lg->encode('jpg', 75));
            Storage::disk('public')->put('post/hero/thumb/' . $name, (string) $sm->encode('jpg', 75));

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

        $video->update($data);
        $video->retag($data['tags']);

        $body = json_decode($data['body']);
        $images = $video->images;

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

        return redirect()->back()->withSuccess('Video berhasil di update.');
    }

    public function makePublic($id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $video->draf = false;
        $video->save();
        return redirect()->back()->withSuccess("Video berhasil di publikasikan.");
    }

    public function makeDraf($id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $video->draf = true;
        $video->save();
        return redirect()->back()->withSuccess("Video telah di jadikan draf");
    }

    public function destroy($id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        if ($video->hero) {
            if(Storage::disk('public')->exists('post/hero/' . $video->hero)) {
                Storage::disk('public')->delete('post/hero/' . $video->hero);
            }
            if(Storage::disk('public')->exists('post/hero/thumb/' . $video->hero)) {
                Storage::disk('public')->delete('post/hero/thumb/' . $video->hero);
            }
        }

        foreach($video->images as $image) {
            if(Storage::disk('public')->exists('post/image/' . $image->name)) {
                Storage::disk('public')->delete('post/image/' . $image->name);
            }
            $image->delete();
        }
        $video->delete();
        return redirect()->route('admin.videos.index')->withSuccess("Video telah dihapus.");
    }


    public function requested()
    {
        $videos = RequestPost::select(['id', 'type', 'title', 'requested_at', 'user_id'])
                                ->where('type', 'video')
                                ->with(['user' => function($query){
                                    $query->select('id','username');
                                }])->whereNotNull('requested_at')->orderBy('requested_at', 'desc')->get();

        return view('admin.video.requested', ['videos' => $videos]);
    }


    public function rejectRequest($id)
    {
        $video = RequestPost::whereNotNull('requested_at')->where('type', 'video')->findOrFail($id);
        $video->requested_at = null;
        $video->save();
        return redirect()->route('admin.videos.requested')->withSuccess('Permintaan Artikel telah di tolak.');
    }

    public function acceptRequest($id)
    {
        $video = RequestPost::whereNotNull('requested_at')->where('type', 'video')->findOrFail($id);

        if ($video->hero) {
            if(Storage::disk('public')->exists('post/hero/request/' . $video->hero)) {
                Storage::disk('public')->move('post/hero/request/' . $video->hero, 'post/hero/' . $video->hero);
            }
            if(Storage::disk('public')->exists('post/hero/request/thumb/' . $video->hero)) {
                Storage::disk('public')->move('post/hero/request/thumb/' . $video->hero, 'post/hero/thumb/' . $video->hero);
            }
        }

        $post = Post::create([
            'type' => $video->type,
            'title' => $video->title,
            'hero' => $video->hero,
            'description' => $video->description,
            'category_id' => $video->category_id,
            'videos' => $video->videos,
            'user_id' => $video->user_id
        ]);

        $tags = [];
        foreach($video->tags as $tag) array_push($tags, $tag->name);
        $post->retag($tags);

        $video->delete();
        return redirect()->route('admin.videos.edit', $post->id)->withSuccess('Artikel minitutor telah diterima.');
    }

    public function showRequested($id)
    {
        $video = RequestPost::whereNotNull('requested_at')->where('type', 'video')->findOrFail($id);
        return view('admin.video.showRequested', ['video' => $video]);
    }

    public function image(Request $request, $id)
    {
        $video = Post::where('type', 'video')->findOrFail($id);
        $data = $request->validate(['file' => 'required|image|max:4000']);
        $name = Str::random(60) . '.jpg';
        Storage::disk('public')->put('post/image/' . $name, (string) Image::make($data['file'])->encode('jpg', 75));
        $video->images()->save(new ModelImage(['name' => $name]));
        return response()->json(['success' => 1, 'file' => ['url' => '/storage/post/image/' . $name]]);
    }
}
