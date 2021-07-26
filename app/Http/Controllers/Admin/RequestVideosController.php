<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HeroHelper;
use App\Helpers\PointHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\RequestPost;
use App\Models\Video;

class RequestVideosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage video');
    }

    public function index()
    {
        $videos = RequestPost::where('requested_at', '!=', null)->where('type', 'video');
        $videos = $videos->orderBy('id', 'desc')->paginate(20);
        return view('request_videos.index', ['videos' => $videos]);
    }

    public function show($id)
    {
        $video = RequestPost::where('requested_at', '!=', null)->where('type', 'video')->findOrFail($id);
        return view('request_videos.show', ['video' => $video]);
    }

    public function accept($id)
    {
        $rVideo = RequestPost::where('requested_at', '!=', null)->where('type', 'video')->findOrFail($id);
        $minitutor = $rVideo->minitutor;

        $data = [
            'type' => 'video',
            'title' => $rVideo->title,
            'hero' => $rVideo->hero,
            'description' => $rVideo->description,
            'body' => $rVideo->body,
        ];
        if($rVideo->category) $data['category_id'] = $rVideo->category->id;

        $video = new Post($data);
        $minitutor->posts()->save($video);

        $rVideo->delete();
        PointHelper::onMinitutorPostCreated($minitutor->user);
        return redirect()->route('videos.edit', $video->id)->withSuccess('Video telah diterima.');
    }

    public function destroy($id)
    {
        $video = RequestPost::where('requested_at', '!=', null)->where('type', 'video')->findOrFail($id);

        VideoHelper::destroy($video->body);
        HeroHelper::destroy($video->hero);

        $video->delete();
        return redirect()->route('request-videos.index')->withSuccess('Video permintaan telah dihapus.');
    }
}
