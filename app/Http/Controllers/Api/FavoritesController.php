<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Playlist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);

        $playlists = $user->subscriptions()
        ->withType(Playlist::class)
        ->with(['playlist' => function($q){
            Playlist::generateQuery($q);
        }])->get()->toArray();
        $articles = $user->subscriptions()
        ->withType(Article::class)
        ->with(['article' => function($q){
            Article::generateQuery($q);
        }])->get()->toArray();

        $response = [];
        foreach(array_merge($playlists, $articles) as $arr){
            if(isset($arr['playlist'])) {
                $data = $arr['playlist'];
                $data['type'] = 'Playlist';
            } else {
                $data = $arr['article'];
                $data['type'] = 'Article';
            }
            $data['favorite_id'] = $arr['id'];
            $data['favorited_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $data['hero'] = HeroHelper::getUrl($data['hero'] ? $data['hero']['name'] : null);
            $data['created_at'] = Carbon::parse($data['created_at'])->timestamp;
            $data['updated_at'] = Carbon::parse($data['updated_at'])->timestamp;
            $data['user'] = $data['minitutor']['user'];
            $data['user']['avatar'] = AvatarHelper::getUrl($data['user']['avatar']);
            $data['rating'] = round($data['rating'], 2);
            unset($data['minitutor']['user']);

            array_push($response, $data);
        }
        $response = array_values(collect($response)->sortBy('favorite_id')->reverse()->toArray());

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type, $id)
    {
        $user = $request->user();
        if($type === 'article') {
            $target = Article::where('draf', false)->whereHas('minitutor', function($q){
                $q->where('active', true);
            })->findOrFail($id);
        } else {
            $target = Playlist::where('draf', false)->whereHas('minitutor', function($q){
                $q->where('active', true);
            })->findOrFail($id);
        }
        if(!$user->hasSubscribed($target)) $user->subscribe($target);
        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $type, $id)
    {
        $user = $request->user();
        if($type === 'article') {
            $target = Article::where('draf', false)->whereHas('minitutor', function($q){
                $q->where('active', true);
            })->findOrFail($id);
        } else {
            $target = Playlist::where('draf', false)->whereHas('minitutor', function($q){
                $q->where('active', true);
            })->findOrFail($id);
        }
        if($user->hasSubscribed($target)) $user->unsubscribe($target);
        return response()->json([], 200);
    }
}
