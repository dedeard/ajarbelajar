<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage video');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return response()->json([], 200);
    }

    public function upload(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
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
