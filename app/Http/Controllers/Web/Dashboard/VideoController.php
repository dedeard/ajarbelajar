<?php

namespace App\Http\Controllers\Web\Dashboard;

use Artesaos\SEOTools\Facades\SEOTools;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Model\Category;
use App\Model\RequestPost;
use App\Model\Video;

class VideoController extends Controller
{
    const driver = 'public';

    private function getVideo($user, $id){
        return $user->requestPosts()
                    ->whereNull('requested_at')
                    ->where('type', 'video')
                    ->findOrFail($id);
    }

    public function index(Request $request)
    {
        $videos = $request->user()->requestPosts()->whereNull('requested_at')->where('type', 'video')->orderBy('updated_at', 'desc')->paginate(12);
        return view('web.dashboard.video.index', ['videos' => $videos]);
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([ 'title' => 'required|string|min:10|max:160', 'type' => 'video' ]);
        $data['type'] = 'video';
        $video = new RequestPost($data);
        $request->user()->requestPosts()->save($video);
        return redirect()->route('dashboard.video.edit', $video->id);
    }

    public function edit(Request $request, $id)
    {
        $video = $this->getVideo($request->user(), $id);
        SEOTools::setTitle($video->title);
        return view('web.dashboard.video.edit', ['video' => $video]);
    }

    public function update(Request $request, $id)
    {
        $video = $this->getVideo($request->user(), $id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category' => 'nullable|string|min:3|max:25',
            'videos' => 'nullable|url|max:250',
            'hero' => 'nullable|image|max:4000',
            'tags' => 'nullable|string|max:150',
        ]);

        if(isset($data['hero'])) {
            if($video->hero) {
                if(Storage::disk(self::driver)->exists('post/hero/request/' . $video->hero)) {
                    Storage::disk(self::driver)->delete('post/hero/request/' . $video->hero);
                }
                if(Storage::disk(self::driver)->exists('post/hero/request/thumb/' . $video->hero)) {
                    Storage::disk(self::driver)->delete('post/hero/request/thumb/' . $video->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(1280, 720, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(640, 360, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk(self::driver)->put('post/hero/request/' . $name, (string) $lg->encode('jpg', 75));
            Storage::disk(self::driver)->put('post/hero/request/thumb/' . $name, (string) $sm->encode('jpg', 75));

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
        return redirect()->back()->withSuccess('Video berhasil di update.');
    }

    public function destroy(Request $request, $id)
    {
        $video = $this->getVideo($request->user(), $id);
        if($video->hero) {
            if(Storage::disk(self::driver)->exists('post/hero/request/' . $video->hero)) {
                Storage::disk(self::driver)->delete('post/hero/request/' . $video->hero);
            }
            if(Storage::disk(self::driver)->exists('post/hero/request/thumb/' . $video->hero)) {
                Storage::disk(self::driver)->delete('post/hero/request/thumb/' . $video->hero);
            }
        }

        foreach($video->videos as $vid){
            if(Storage::disk(self::driver)->exists('post/video/' . $vid->name)) {
                Storage::disk(self::driver)->delete('post/video/' . $vid->name);
            }
            $vid->delete();
        }

        $video->delete();
        return redirect()->back()->withSuccess('Video berhasil di hapus.');
    }

    public function uploadVideo(Request $request, $id)
    {
        $video = $request->user()->requestPosts()->whereNull('requested_at')->where('type', 'video')->findOrFail($id);
        $data = $request->validate([
            'file' => 'required|mimes:mp4,mov,mkv,avi|max:250000'
        ]);
        $name = Str::random(60) . '.' . $data['file']->extension();
        Storage::disk(self::driver)->put('post/video/' . $name, file_get_contents($data['file']));
        $video->videos()->save(new Video(['name' => $name]));
        return response()->json(['success' => 1, 'file' => ['url' => '/storage/post/video/' . $name]]);
    }

    public function destroyVideo(Request $request, $id, $video_id){
        $post = $request->user()->requestPosts()->whereNull('requested_at')->where('type', 'video')->findOrFail($id);
        $video = $post->videos()->findOrFail($video_id);
        if(Storage::disk(self::driver)->exists('post/video/' . $video->name)) {
            Storage::disk(self::driver)->delete('post/video/' . $video->name);
        }
        $video->delete();
        return redirect()->back()->withSuccess('Video telah dihapus.');
    }
}
