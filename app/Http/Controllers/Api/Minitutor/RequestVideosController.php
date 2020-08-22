<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Helpers\CategoryHelper;
use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestPlaylistResorurce;
use App\Models\RequestPlaylist;
use App\Models\RequestVideo;
use Illuminate\Http\Request;

class RequestVideosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'minitutor:active']);
    }

    public function index(Request $request)
    {
        $minitutor = $request->user()->minitutor;
        $playlists = $minitutor->requestPlaylists;
        return response()->json(RequestPlaylistResorurce::collection($playlists), 200);
    }

    public function store(Request $request)
    {
        $minitutor = $request->user()->minitutor;

        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable'
        ]);

        $playlist = new RequestPlaylist($data);
        $minitutor->requestPlaylists()->save($playlist);
        return response()->json(RequestPlaylistResorurce::make($playlist), 200);
    }

    public function update(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
            'category' => 'nullable|string'
        ]);
        if(isset($data['category'])){
            $data['category_id'] = CategoryHelper::getCategoryIdOrCreate($data['category']);
            unset($data['category']);
        } else {
            $data['category_id'] = null;
        }
        $playlist->update($data);
        $this->timestamps = false;
        if(!$request->input('requested') && $playlist->requested_at){
            $playlist->requested_at = null;
            $playlist->save();
        } elseif($request->input('requested') && !$playlist->requested_at) {
            $playlist->requested_at = now();
            $playlist->save();
        }
        $this->timestamps = true;
        return response()->json(RequestPlaylistResorurce::make($playlist), 200);
    }

    public function updateHero(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);
        $data = $request->validate(['hero' => 'nullable|image|max:4000']);
        $data['hero'] = HeroHelper::generate($data['hero'], $playlist->hero);
        return response()->json(RequestPlaylistResorurce::make($playlist), 200);
    }

    public function uploadVideo(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);

        $data = $request->validate([
            'file' => 'required|mimes:mp4,mov,avi,fly|max:250000'
        ]);

        $name = VideoHelper::generate($data['file']);
        $last = $playlist->videos()->orderBy('index', 'desc')->first();
        $index = 1;
        if($last) $index = $last->index + 1;
        $video = new RequestVideo([
            'name' => $name,
            'index' => $index,
        ]);
        $playlist->videos()->save($video);
        return response()->json([
            'id' => $video->id,
            'url' => $video->getUrl(),
            'index' => $video->index,
        ], 200);
    }

    public function destroyVideo(Request $request, $playlist_id, $video_id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($playlist_id);

        $video = $playlist->videos()->findOrFail($video_id);
        VideoHelper::destroy($video->name);
        $video->delete();
        return response()->json([], 200);
    }

    public function destroy(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $playlist = $minitutor->requestPlaylists()->findOrFail($id);
        foreach($playlist->videos as $video) {
            VideoHelper::destroy($video->name);
            $video->delete();
        }
        HeroHelper::destroy($playlist->hero);
        $playlist->delete();
        return response()->json([], 200);
    }
}
