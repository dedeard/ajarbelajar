<?php

namespace App\Http\Controllers\Admin\Api;

use App\Helpers\VideoHelper;
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

    public function canUpload($id)
    {
        Playlist::findOrFail($id);
        return response()->json([], 200);
    }

    public function store(Request $request, $id)
    {
        $playlist = Playlist::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|unique:videos,name'
        ]);
        $last = $playlist->videos()->orderBy('index', 'desc')->first();
        $index = 1;
        if($last) {
            $index = $last->index + 1;
        }
        $video = new Video([
            'name' => $data['name'],
            'index' => $index,
        ]);
        $playlist->videos()->save($video);
        return response()->json([
            'id' => $video->id,
            'url' => $video->getUrl(),
            'index' => $video->index,
        ], 200);
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        VideoHelper::destroy($video->name);
        $video->delete();
        return response()->json([], 200);
    }
}
