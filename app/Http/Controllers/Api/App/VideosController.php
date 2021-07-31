<?php

namespace App\Http\Controllers\Api\App;

use App\Jobs\AfterViewPostJob;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\VideoResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Cache, DB;

class VideosController extends Controller
{
    public function index(Request $request)
    {
        return Cache::remember('videos.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            $videos = Post::postListQuery(Post::where('type', 'video'))->orderBy('id', 'desc')->paginate(12);
            return PostResource::collection($videos);
        });
    }

    public function show($slug)
    {
        $data = Cache::remember('videos.show.' . $slug, config('cache.age'), function () use ($slug) {
            $query = Post::whereNotNull('posted_at')->where('type', 'video');
            $query->with(['category']);
            $query->with(['minitutor' => function ($q) {
                $q->with(['user' => function ($q) {
                    $q->select([ 'id', 'name', 'avatar', 'points', 'username' ]);
                }]);
            }]);
            $query->with(['comments' => function ($q) {
                $q->with(['user' => function ($q) {
                    $q->select([ 'id', 'name', 'avatar', 'points', 'username' ]);
                }]);
                $q->where('public', true);
            }]);
            $query->withCount('activities as view_count');
            $query->withCount(['feedback as rating' => function ($q) {
                $q->select(DB::raw('coalesce(avg((understand + inspiring + language_style + content_flow)/4),0)'));
            }, 'feedback']);
            $query->whereHas('minitutor', function ($q) {
                $q->where('active', true);
            });
            $video = $query->where('slug', $slug)->firstOrFail();

            $latesPosts = $video->minitutor
                ->posts()
                ->whereNotNull('posted_at')
                ->where('id', '!=', $video->id)
                ->take(8)
                ->get()
                ->map(function($item){
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'posted_at' => $item->posted_at,
                ];
            });

            return [
                'video' => VideoResource::make($video),
                'latesPosts' => $latesPosts,
            ];
        });
        AfterViewPostJob::dispatchAfterResponse($data['video'], auth('api')->user());
        return $data;
    }

    public function news()
    {
        $videos = Cache::remember('videos.news', config('cache.age'), function () {
            $videos = Post::postListQuery(Post::where('type', 'video'))->orderBy('posted_at', 'desc')->limit(8)->get();
            return PostResource::collection($videos);
        });
        return $videos;
    }
}
