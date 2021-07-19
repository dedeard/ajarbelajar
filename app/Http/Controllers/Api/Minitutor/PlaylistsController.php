<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostsResource;
use App\Http\Resources\Api\PlaylistResource;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Cache, DB;

class PlaylistsController extends Controller
{
    public function index()
    {
        $minitutor = $request->user()->minitutor;
        $data = Cache::remember('minitutor.'. $minitutor->id .'.playlists', config('cache.age'), function () use ($minitutor){
            $playlists = Playlist::postListQuery($minitutor->playlists(), true)->get();
            return PostsResource::collection($playlists);
        });
        return response()->json($data, 200);
    }

    public function show($slug)
    {
        $minitutor = $request->user()->minitutor;
        $data = Cache::remember('minitutor.'. $minitutor->id .'.playlists.show.' . $slug, config('cache.age'), function () use ($slug, $minitutor) {
            $query = $minitutor->playlists()->select('*', DB::raw("'Playlist' as type"));
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

            return PlaylistResource::make($playlist);
        });
        return  response()->json($data, 200);
    }
}
