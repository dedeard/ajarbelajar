<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Helpers\HeroHelper;
use App\Helpers\VideoHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaylistResource;
use App\Models\Activity;
use App\Models\Playlist;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlaylistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = Playlist::generateQuery(Playlist::query())->orderBy('id', 'desc')->get()->toArray();
        $response = [];
        foreach($playlists as $playlist) {
            $arr = $playlist;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return response()->json($response, 200);
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

        $arr = $playlist->toArray();
        $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
        $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
        $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
        $arr['minitutor']['created_at'] = Carbon::parse($arr['minitutor']['created_at'])->timestamp;
        $arr['minitutor']['updated_at'] = Carbon::parse($arr['minitutor']['updated_at'])->timestamp;
        $arr['user'] = $arr['minitutor']['user'];
        $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
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
}
