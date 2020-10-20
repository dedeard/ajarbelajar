<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Playlist;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PlaylistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $playlists = Cache::remember('playlists.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            return Playlist::generateQuery(Playlist::query())->orderBy('id', 'desc')->paginate(6)->toArray();
        });
        $response = [];
        foreach($playlists['data'] as $playlist) {
            $arr = $playlist;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['rating'] = round($arr['rating'], 2);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        $playlists['data'] = $response;
        return response()->json($playlists, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $playlist = Playlist::generateQuery(Playlist::query(), true)->where('slug', $slug)->firstOrFail();
        $minitutor = $playlist->minitutor;

        if($user = auth('api')->user()) {
            $q = $playlist->activities()->where('user_id', $user->id);
            if ($q->exists()){
                $activity = $q->first();
                $activity->updated_at = now();
                $activity->save();
            } else {
                $activity = new Activity([ 'user_id' => $user->id ]);
                $playlist->activities()->save($activity);
                if($user->activities()->count() > 8) {
                    $user->activities()->orderBy('updated_at', 'asc')->first()->delete();
                }
            }
        }

        $latesArticles = $minitutor->articles()
        ->select(['minitutor_id', 'id', 'title', 'slug', 'draf', 'created_at'])
        ->where('draf', false)
        ->orderBy('id', 'desc')
        ->take(4)
        ->get()
        ->toArray();

        $latesPlaylists = $minitutor->playlists()
        ->select(['minitutor_id', 'id', 'title', 'slug', 'draf', 'created_at'])
        ->where('draf', false)
        ->orderBy('id', 'desc')
        ->take(4)
        ->get()
        ->toArray();

        $lates = [];
        foreach($latesArticles as $arr) {
            array_push($lates, [
                'id' => $arr['id'],
                'title' => $arr['title'],
                'slug' => $arr['slug'],
                'created_at' => Carbon::parse($arr['created_at'])->timestamp,
                'type' => 'Article'
            ]);
        }
        foreach($latesPlaylists as $arr) {
            array_push($lates, [
                'id' => $arr['id'],
                'title' => $arr['title'],
                'slug' => $arr['slug'],
                'created_at' => Carbon::parse($arr['created_at'])->timestamp,
                'type' => 'Playlist'
            ]);
        }

        $arr = $playlist->toArray();
        $arr['lates'] = $lates;
        $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
        $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
        $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
        $arr['minitutor']['created_at'] = Carbon::parse($arr['minitutor']['created_at'])->timestamp;
        $arr['minitutor']['updated_at'] = Carbon::parse($arr['minitutor']['updated_at'])->timestamp;
        $arr['user'] = $arr['minitutor']['user'];
        $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
        $arr['rating'] = round($arr['rating'], 2);
        unset($arr['minitutor']['user']);

        $comments = [];
        foreach($arr['comments'] as $comment){
            $data = [
                'id' => $comment['id'],
                'body' => $comment['body'],
                'user' => $comment['user'],
                'created_at' => Carbon::parse($comment['created_at'])->timestamp,
            ];
            $data['user']['avatar'] = AvatarHelper::getUrl($data['user']['avatar']);
            array_push($comments, $data);
        }
        $arr['comments'] = $comments;

        $videos = [];
        foreach($arr['videos'] as $video){
            unset($video['videoable_type']);
            unset($video['videoable_id']);
            $video['created_at'] = Carbon::parse($video['created_at'])->timestamp;
            $video['updated_at'] = Carbon::parse($video['created_at'])->timestamp;
            $video['url'] = VideoHelper::getUrl($video['name']);
            array_push($videos, $video);
        }
        $arr['videos'] = $videos;

        return response()->json($arr, 200);
    }

    public function storeView(Request $request, $id)
    {
        $playlist = Playlist::where('draf', false)->whereHas('minitutor', function($q){
            $q->where('active', true);
        })->findOrFail($id);

        $view = null;
        if($user = auth('api')->user()) {
            $view = new View([
                'user_id' => $user->id,
                'ip' => $request->getClientIp() ?? '',
                'agent' => $request->header('User-Agent') ?? ''
            ]);
        } else {
            $view = new View([
                'ip' => $request->getClientIp() ?? '',
                'agent' => $request->header('User-Agent') ?? ''
            ]);
        }
        $playlist->views()->save($view);
        return response()->json([], 200);
    }

    public function popular()
    {
        $playlists = Playlist::generateQuery(Playlist::query())->orderBy('views_count', 'desc')->limit(5)->get()->toArray();
        $response = [];
        foreach($playlists as $playlist) {
            $arr = $playlist;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['rating'] = round($arr['rating'], 2);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return response()->json($response, 200);
    }

    public function news()
    {
        $playlists = Playlist::generateQuery(Playlist::query())->orderBy('id', 'desc')->limit(4)->get()->toArray();
        $response = [];
        foreach($playlists as $playlist) {
            $arr = $playlist;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['rating'] = round($arr['rating'], 2);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return response()->json($response, 200);
    }
}
