<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
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
            'category_id' => 'nullable|numeric|exists:categories,id',
            'body' => 'nullable',
            'hero' => 'nullable|image|max:4000'
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
            $lg = Image::make($data['hero'])->fit(720*1.5, 480*1.5, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(720/1.5, 480/1.5, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk('public')->put('post/hero/' . $name, (string) $lg->encode('jpg', 90));
            Storage::disk('public')->put('post/hero/thumb/' . $name, (string) $sm->encode('jpg', 90));

            $data['hero'] = $name;
        } else {
            unset($data['hero']);
        }

        $video->update($data);
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
        $video->delete();
        return redirect()->route('admin.video.index')->withSuccess("Video telah dihapus.");
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

        $video->delete();
        return redirect()->route('admin.videos.edit', $post->id)->withSuccess('Artikel minitutor telah diterima.');
    }

    public function showRequested($id)
    {
        $video = RequestPost::whereNotNull('requested_at')->where('type', 'video')->findOrFail($id);
        return view('admin.video.showRequested', ['video' => $video]);
    }
}
