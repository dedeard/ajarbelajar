<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;

class PlaylistsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage playlist');
    }

    public function destroyVideo($video_id)
    {
        $video = Video::findOrFail($video_id);
        $video->delete();
        return response()->json([], 200);
    }

    public function uploadVideo(Request $request, $playlist_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $data = $request->validate([
            'file' => 'required|mimes:mp4,mov,avi,fly|max:250000'
        ]);
        $name = Video::upload($data['file']);
        $last = $playlist->videos()->orderBy('index', 'desc')->first();
        $index = 1;
        if($last) $index = $last->index + 1;
        $video = new Video([
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
}
