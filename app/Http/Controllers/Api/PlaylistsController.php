<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostsResource;
use App\Http\Resources\LatesPostResource;
use App\Http\Resources\PlaylistResource;
use App\Jobs\AfterViewPostJob;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PlaylistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Cache::remember('playlists.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            $playlists =  Playlist::postListQuery(Playlist::query())->orderBy('id', 'desc')->paginate(6);
            return PostsResource::collection($playlists);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $data = Cache::remember('playlists.show.' . $slug, config('cache.age'), function () use ($slug) {
            $query = Playlist::select('*', DB::raw("'Playlist' as type"));
            $query->with(['hero', 'category', 'videos']);
            $query->with(['minitutor' => function($q) {
                $q->with('user');
            }]);
            $query->with('videos');
            $query->with(['comments' => function($q){
                $q->with(['user' => function($q){
                    $q->select([
                        'id',
                        'name',
                        'avatar',
                        'points',
                        'username'
                    ]);
                }]);
                $q->where('public', true);
            }]);
            $query->withCount(['feedback as rating' => function($q){
                $q->select(DB::raw('coalesce(avg((understand + inspiring + language_style + content_flow)/4),0)'));
            }, 'feedback']);
            $query->whereHas('minitutor', function($q){
                $q->where('active', true);
            });

            $playlist = $query->where('slug', $slug)->firstOrFail();
            $latesPosts = $playlist->minitutor->latesPosts()->take(8)->get();

            return [
                'playlist' => PlaylistResource::make($playlist),
                'latesPosts' => LatesPostResource::collection($latesPosts)
            ];
        });

        AfterViewPostJob::dispatchAfterResponse($data['playlist'], auth('api')->user());
    }


    public function popular()
    {
        return Cache::remember('playlists.popular', config('cache.age'), function () {
            $playlists = Playlist::postListQuery(Playlist::query())->orderBy('view_count', 'desc')->limit(5)->get();
            return PostsResource::collection($playlists);
        });
    }

    public function news()
    {
        return Cache::remember('playlists.news', config('cache.age'), function () {
            $playlists = Playlist::postListQuery(Playlist::query())->orderBy('id', 'desc')->limit(8)->get();
            return PostsResource::collection($playlists);
        });
    }
}
