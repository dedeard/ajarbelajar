<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Model\RequestVideo;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Model\Category;

class VideoController extends Controller
{
    const driver = 'public';
    public function index(Request $request)
    {
        $videos = $request->user()->requestVideos()->whereNull('requested_at')->orderBy('updated_at', 'desc')->paginate(12);
        return view('web.dashboard.video.index', ['videos' => $videos]);
    }
    
    public function store(Request $request)
    {
        
        $data = $request->validate([ 'title' => 'required|string|min:10|max:160' ]);
        $video = new RequestVideo($data);
        $request->user()->requestVideos()->save($video);
        return redirect()->route('dashboard.video.edit', $video->id);
    }

    public function edit(Request $request, $id)
    {
        $video = $request->user()->requestVideos()->whereNull('requested_at')->findOrFail($id);
        $categories = Category::all();
        return view('web.dashboard.video.edit', ['video' => $video, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $video = $request->user()->requestVideos()->whereNull('requested_at')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'videos' => 'nullable|url|max:250',
            'hero' => 'nullable|image|max:4000'
        ]);

        if(isset($data['hero'])) {
            if($video->hero) {
                if(Storage::disk(self::driver)->exists('video/request/hero/' . $video->hero)) {
                    Storage::disk(self::driver)->delete('video/request/hero/' . $video->hero);
                }
                if(Storage::disk(self::driver)->exists('video/request/hero/thumb/' . $video->hero)) {
                    Storage::disk(self::driver)->delete('video/request/hero/thumb/' . $video->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(720*1.5, 480*1.5, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(720/1.5, 480/1.5, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk(self::driver)->put('video/request/hero/' . $name, (string) $lg->encode('jpg', 90));
            Storage::disk(self::driver)->put('video/request/hero/thumb/' . $name, (string) $sm->encode('jpg', 90));

            $data['hero'] = $name;
        } else {
            unset($data['hero']);
        }

        $video->update($data);
        return redirect()->back()->withSuccess('Video berhasil di update.');
    }

    public function destroy(Request $request, $id)
    {
        $video = $request->user()->requestVideos()->whereNull('requested_at')->findOrFail($id);
        if($video->hero) {
            if(Storage::disk(self::driver)->exists('video/request/hero/' . $video->hero)) {
                Storage::disk(self::driver)->delete('video/request/hero/' . $video->hero);
            }
            if(Storage::disk(self::driver)->exists('video/request/hero/thumb/' . $video->hero)) {
                Storage::disk(self::driver)->delete('video/request/hero/thumb/' . $video->hero);
            }
        }
        $video->delete();
        return redirect()->back()->withSuccess('Video berhasil di hapus.');
    }
}
