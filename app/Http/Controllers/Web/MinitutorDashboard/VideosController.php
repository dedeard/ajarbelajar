<?php

namespace App\Http\Controllers\Web\MinitutorDashboard;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\RequestPost;
use App\Model\Video;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class VideosController extends Controller
{
    public function index(Request $request)
    {
        $videos = $request->user()->requestPosts()->where('type', 'video');
        $videos = $videos->exclude(['description', 'body']);
        $videos = $videos->with(['category']);
        if ($request->input('search')) {
            $search = '%' . $request->input('search') . '%';
            $videos = $videos->where('title', 'like', $search);
        }
        $videos = $videos->orderBy('updated_at', 'desc');
        $videos = $videos->paginate(12)->appends(['search' => $request->input('search')]);
        return view('web.minitutor-dashboard.videos.index', [ 'videos' => $videos]);
    }

    public function publishToggle(Request $request, $id)
    {
        $video = $request->user()->requestPosts()->where('type', 'video')->findOrFail($id);
        if($video->requested_at) {
            $video->requested_at = null;
            $video->save();
            return redirect()->back()->withSuccess('Berhasil Membatalkan permintaan untuk mempublish Video.');
        } else {
            $video->requested_at = now();
            $video->save();
            return redirect()->back()->withSuccess('Terima kasih.. Video anda segera akan kami tinjau untuk di publikasikan.');
        }
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([ 'title' => 'required|string|min:3|max:160' ]);
        $data['type'] = 'video';
        $video = new RequestPost($data);
        $request->user()->requestPosts()->save($video);
        return redirect()->route('dashboard.minitutor.videos.edit', $video->id);
    }

    public function create()
    {
        return view('web.minitutor-dashboard.videos.create');
    }

    public function edit(Request $request, $id)
    {
        $video = $request->user()->requestPosts()->where('type', 'video')->findOrFail($id);
        SEOTools::setTitle($video->title);
        return view('web.minitutor-dashboard.videos.edit', ['video' => $video]);
    }

    public function uploadVideo(Request $request, $id)
    {
        $video = $request->user()->requestPosts()->where('type', 'video')->findOrFail($id);
        $data = $request->validate([
            'file' => 'required|mimes:mp4,mov,mkv,avi|max:250000'
        ]);
        $name = Str::random(60) . '.' . $data['file']->extension();
        Storage::disk('public')->put('post/video/' . $name, file_get_contents($data['file']));
        $video->videos()->save(new Video(['name' => $name]));
        return response()->json(['success' => 1, 'file' => ['url' => '/storage/post/video/' . $name]]);
    }

    public function destroyVideo(Request $request, $id, $video_id){
        $post = $request->user()->requestPosts()->where('type', 'video')->findOrFail($id);
        $video = $post->videos()->findOrFail($video_id);
        if(Storage::disk('public')->exists('post/video/' . $video->name)) {
            Storage::disk('public')->delete('post/video/' . $video->name);
        }
        $video->delete();
        return redirect()->back()->withSuccess('Video telah dihapus.');
    }

    public function update(Request $request, $id)
    {
        $video = $request->user()->requestPosts()->where('type', 'video')->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:3|max:160',
            'description' => 'nullable|min:3|max:300',
            'category' => 'nullable|string|min:3|max:25',
            'videos' => 'nullable|url|max:250',
            'hero' => 'nullable|image|max:4000',
            'tags' => 'nullable|string|max:150',
        ]);

        if(isset($data['hero'])) {
            if($video->hero) {
                if(Storage::disk('public')->exists('post/hero/request/' . $video->hero)) {
                    Storage::disk('public')->delete('post/hero/request/' . $video->hero);
                }
                if(Storage::disk('public')->exists('post/hero/request/thumb/' . $video->hero)) {
                    Storage::disk('public')->delete('post/hero/request/thumb/' . $video->hero);
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

        $video->update($data);
        $video->retag($data['tags']);

        if($request->publish === 'on'){
            $video->requested_at = now();
            $video->updated_at = now();
            $video->save();
        } else {
            $video->requested_at = null;
            $video->updated_at = now();
            $video->save();
        }
        return redirect()->back()->withSuccess('Video berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $video = $request->user()->requestPosts()->where('type', 'video')->findOrFail($id);
        if($video->hero) {
            if(Storage::disk('public')->exists('post/hero/request/' . $video->hero)) {
                Storage::disk('public')->delete('post/hero/request/' . $video->hero);
            }
            if(Storage::disk('public')->exists('post/hero/request/thumb/' . $video->hero)) {
                Storage::disk('public')->delete('post/hero/request/thumb/' . $video->hero);
            }
        }

        foreach($video->videos as $vid){
            if(Storage::disk('public')->exists('post/video/' . $vid->name)) {
                Storage::disk('public')->delete('post/video/' . $vid->name);
            }
            $vid->delete();
        }

        $video->delete();
        return redirect()->back()->withSuccess('Video berhasil dihapus.');
    }
}
