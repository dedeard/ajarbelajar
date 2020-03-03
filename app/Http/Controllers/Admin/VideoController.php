<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Video;
use App\Model\Category;
use App\Model\RequestVideo;
use Carbon\Carbon;
use Helper;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    const driver = 'public';
    public function index()
    {
        $videos = Video::select(['id', 'user_id', 'title', 'draf', 'created_at'])->with(['user' => function($query){
            $query->select(['id', 'username'])->with(['profile' => function($query){
                $query->select(['id', 'user_id', 'first_name', 'last_name']);
            }]);
        }])->get();

        $data = [];

        foreach($videos as $video) {
            array_push($data, [
                'id' => $video->id,
                'user_id' => $video->user_id,
                'name' => $video->user->name(),
                'username' => $video->user->username,
                'title' => $video->title,
                'status' => $video->draf ? "Draf" : "Public",
                'created_at' => $video->created_at->format('Y/m/d')
            ]);
        }

        return view('admin.video.index', ['videos' => $data]);
    }


    public function edit($id)
    {
        $video = Video::findOrFail($id);
        Helper::compileEditorJs($video->body);
        $categories = Category::all();
        return view('admin.video.edit', ['video' => $video, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:10|max:160',
            'description' => 'nullable|min:30|max:300',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'body' => 'nullable',
            'hero' => 'nullable|image|max:4000'
        ]);

        if(isset($data['hero'])) {
            if($video->hero) {
                if(Storage::disk(self::driver)->exists('video/hero/' . $video->hero)) {
                    Storage::disk(self::driver)->delete('video/hero/' . $video->hero);
                }
                if(Storage::disk(self::driver)->exists('video/hero/thumb/' . $video->hero)) {
                    Storage::disk(self::driver)->delete('video/hero/thumb/' . $video->hero);
                }
            }
            $lg = Image::make($data['hero'])->fit(720*1.5, 480*1.5, function ($constraint) {
                $constraint->aspectRatio();
            });
            $sm = Image::make($data['hero'])->fit(720/1.5, 480/1.5, function ($constraint) {
                $constraint->aspectRatio();
            });

            $name = Str::random(60) . '.jpg';

            Storage::disk(self::driver)->put('video/hero/' . $name, (string) $lg->encode('jpg', 90));
            Storage::disk(self::driver)->put('video/hero/thumb/' . $name, (string) $sm->encode('jpg', 90));

            $data['hero'] = $name;
        } else {
            unset($data['hero']);
        }

        $video->update($data);
        return redirect()->back()->withSuccess('Video berhasil di update.');
    }

    public function makePublic($id)
    {
        $video = Video::findOrFail($id);
        $video->draf = false;
        $video->save();
        return redirect()->back()->withSuccess("Video berhasil di publikasikan.");
    }

    public function makeDraf($id)
    {
        $video = Video::findOrFail($id);
        $video->draf = true;
        $video->save();
        return redirect()->back()->withSuccess("Video telah di jadikan draf");
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        if ($video->hero) {
            if(Storage::disk(self::driver)->exists('video/hero/' . $video->hero)) {
                Storage::disk(self::driver)->delete('video/hero/' . $video->hero);
            }
            if(Storage::disk(self::driver)->exists('video/hero/thumb/' . $video->hero)) {
                Storage::disk(self::driver)->delete('video/hero/thumb/' . $video->hero);
            }
        }
        $video->delete();
        return redirect()->route('admin.video.index')->withSuccess("Video telah dihapus.");
    }


    public function requested()
    {
        $videos = RequestVideo::select(['id', 'title', 'requested_at', 'user_id'])->with(['user' => function($query){
            $query->select('id','username');
        }])->whereNotNull('requested_at')->orderBy('requested_at', 'desc')->get();

        $data = [];

        foreach($videos as $video) {
            array_push($data, [
                'id' => $video->id,
                'user_id' => $video->user_id,
                'title' => $video->title,
                'username' => $video->user->username,
                'requested_at' => Carbon::parse($video->requested_at)->format('Y/m/d')
            ]);
        }
        return view('admin.video.requested', ['videos' => $data]);
    }


    public function rejectRequest($id)
    {
        $video = RequestVideo::whereNotNull('requested_at')->findOrFail($id);
        $video->requested_at = null;
        $video->save();
        return redirect()->route('admin.video.requested')->withSuccess('Permintaan Artikel telah di tolak.');
    }

    public function acceptRequest($id)
    {
        $video = RequestVideo::whereNotNull('requested_at')->findOrFail($id);
        if ($video->hero) {
            if(Storage::disk(self::driver)->exists('video/request/hero/' . $video->hero)) {
                Storage::disk(self::driver)->move('video/request/hero/' . $video->hero, 'video/hero/' . $video->hero);
            }
            if(Storage::disk(self::driver)->exists('video/request/hero/thumb/' . $video->hero)) {
                Storage::disk(self::driver)->move('video/request/hero/thumb/' . $video->hero, 'video/hero/thumb/' . $video->hero);
            }
        }
        $data = Video::create([
            'title' => $video->title,
            'category_id' => $video->category_id,
            'hero' => $video->hero,
            'description' => $video->description,
            'videos' => $video->videos,
            'user_id' => $video->user_id
        ]);
        $video->delete();
        return redirect()->route('admin.video.edit', $data->id)->withSuccess('Video minitutor telah diterima.');
    }

    public function showRequested($id)
    {
        $video = RequestVideo::whereNotNull('requested_at')->findOrFail($id);
        return view('admin.video.showRequested', ['video' => $video]);
    }
}
