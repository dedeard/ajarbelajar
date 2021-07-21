<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RequestPlaylistResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\RequestPlaylist;
use App\Models\Video;
use Illuminate\Http\Request;

class RequestPlaylistsController extends Controller
{
    public function index()
    {
        $minitutor = $request->user()->minitutor;
        $playlists = $minitutor->requestPlaylists()->with(['hero', 'category'])->orderBy('updated_at', 'desc')->get();
        return response()->json(RequestPlaylistResource::collection($articles), 200);
    }

    public function show(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->with(['hero', 'category', 'videos'])->findOrFail($id);
        return response()->json(RequestPlaylistResource::make($playlist), 200);
    }

    public function store(Request $request)
    {
        $minitutor = $request->user()->minitutor;

        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
        ]);

        $playlist = new RequestPlaylist($data);
        $minitutor->requestPlaylists()->save($playlist);
        return response()->json(['id' => $playlist->id], 200);
    }

    public function update(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
            'category' => 'nullable|string',
        ]);
        if (isset($data['category'])) {
            $data['category_id'] = Category::getCategoryOrCreate($data['category'])->id;
            unset($data['category']);
        } else {
            $data['category_id'] = null;
        }
        $playlist->update($data);
        $this->timestamps = false;
        if (!$request->input('requested') && $playlist->requested_at) {
            $playlist->requested_at = null;
            $playlist->save();
        } elseif ($request->input('requested') && !$playlist->requested_at) {
            $playlist->requested_at = now();
            $playlist->save();
        }
        $this->timestamps = true;
        $playlist->load('videos');
        return response()->json(RequestPlaylistResource::make($playlist), 200);
    }

    public function updateHero(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);
        $data = $request->validate(['hero' => 'required|image|max:4000']);

        $name = HeroHelper::generate($data['hero'], $playlist->hero ? $playlist->hero->name : null);
        $hero = $playlist->hero;
        if ($hero) {
            $hero->update([
                'type' => 'hero',
                'name' => $name,
                'original_name' => $data['hero']->getClientOriginalName(),
            ]);
        } else {
            $playlist->hero()->save(new Image([
                'type' => 'hero',
                'name' => $name,
                'original_name' => $data['hero']->getClientOriginalName(),
            ]));
            $playlist->load('hero');
        }
        $playlist->touch();
        return response()->json(HeroHelper::getUrl($name), 200);
    }

    public function uploadVideo(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);

        $data = $request->validate([
            'file' => 'required|mimes:mp4,mov,avi,fly|max:250000',
        ]);

        $name = VideoHelper::upload($data['file']);
        $last = $playlist->videos()->orderBy('index', 'desc')->first();
        $index = 1;
        if ($last) {
            $index = $last->index + 1;
        }

        $video = new Video([
            'name' => $name,
            'index' => $index,
            'original_name' => $data['file']->getClientOriginalName(),
        ]);
        $playlist->videos()->save($video);
        $playlist->touch();
        $playlist->load('videos');
        return response()->json(RequestPlaylistResource::make($playlist), 200);
    }

    public function destroyVideo(Request $request, $playlist_id, $video_id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($playlist_id);

        $video = $playlist->videos()->findOrFail($video_id);
        VideoHelper::destroy($video->name);
        $video->delete();
        $playlist->load('videos');
        return response()->json(RequestPlaylistResource::make($playlist), 200);
    }

    public function destroy(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);
        foreach ($playlist->videos as $video) {
            VideoHelper::destroy($video->name);
            $video->delete();
        }
        HeroHelper::destroy($playlist->hero ? $playlist->hero->name : null);
        $playlist->delete();
        return response()->noContent();
    }

    public function updateIndex(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);
        $data = $request->validate(['index' => 'required|string']);

        $index = explode('|', $data['index']);
        if (count($index) === $playlist->videos()->count()) {
            $x = 1;
            foreach ($index as $id) {
                $video = $playlist->videos()->find($id);
                if ($video) {
                    $video->update(['index' => $x]);
                    $x = $x + 1;
                } else {
                    return abort(422);
                }
            }
        } else {
            return abort(422);
        }
        $playlist->load('videos');
        return response()->json(RequestPlaylistResource::make($playlist), 200);
    }
}
