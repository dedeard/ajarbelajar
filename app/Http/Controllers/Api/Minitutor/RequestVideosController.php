<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestVideoResource;
use App\Models\Category;
use App\Models\RequestPost;
use Illuminate\Http\Request;

class RequestVideosController extends Controller
{
    public function index(Request $request)
    {
        $minitutor = $request->user()->minitutor;
        $videos = $minitutor->requestPosts()->with(['category'])->where('type', 'video')->orderBy('updated_at', 'desc')->get();
        return response()->json(RequestVideoResource::collection($videos), 200);
    }

    public function show(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $video = $minitutor->requestPosts()->with(['category'])->where('type', 'video')->findOrFail($id);
        return response()->json(RequestVideoResource::make($video), 200);
    }

    public function store(Request $request)
    {
        $minitutor = $request->user()->minitutor;

        $data = $request->validate([
            'title' => 'required|string|min:6|max:250',
            'description' => 'nullable',
        ]);

        $data['type'] = 'video';
        $video = new RequestPost($data);
        $minitutor->requestPosts()->save($video);
        return response()->json(['id' => $video->id], 200);
    }

    public function update(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $video = $minitutor->requestPosts()->with(['category'])->where('type', 'video')->findOrFail($id);

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

        $video->update($data);

        if (!$request->input('requested') && $video->requested_at) {
            $video->requested_at = null;
            $video->save();
        } elseif ($request->input('requested') && !$video->requested_at) {
            $video->requested_at = now();
            $video->save();
        }

        return response()->json(RequestVideoResource::make($video), 200);
    }

    public function updateHero(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $video = $minitutor->requestPosts()->where('type', 'video')->findOrFail($id);

        $data = $request->validate(['hero' => 'image|max:4000']);
        $name = HeroHelper::generate($data['hero'], $video->hero);

        $video->hero = $name;
        $video->save();

        return response()->json(HeroHelper::getUrl($name), 200);
    }

    public function uploadVideo(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $video = $minitutor->requestPosts()->where('type', 'video')->findOrFail($id);

        $data = $request->validate([
            'file' => 'required|mimes:mp4,mov,avi,fly|max:250000',
        ]);

        $name = VideoHelper::upload($data['file'], $video->body);
        $video->body = $name;
        $video->save();

        return response()->json(VideoHelper::getUrl($name), 200);
    }

    public function destroy(Request $request, $id)
    {
        $minitutor = $request->user()->minitutor;
        $video = $minitutor->requestPosts()->where('type', 'video')->findOrFail($id);

        foreach ($playlist->videos as $video) {
            $video->delete();
        }
        VideoHelper::destroy($video->body);
        HeroHelper::destroy($video->hero);
        $video->delete();
        return response()->noContent();
    }
}
