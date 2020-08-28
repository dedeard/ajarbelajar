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
            $data = [
                'id' => $arr['id'],
                'created_at' => Carbon::parse($arr['created_at'])->timestamp,
                'updated_at' => Carbon::parse($arr['updated_at'])->timestamp,
            ];

            if(isset($arr['playlist'])) {
                $post = $arr['playlist'];
            } else {
                $post = $arr['article'];
            }

            $post['hero'] = HeroHelper::getUrl($post['hero'] ? $post['hero']['name'] : null);
            $post['created_at'] = Carbon::parse($post['created_at'])->timestamp;
            $post['updated_at'] = Carbon::parse($post['updated_at'])->timestamp;
            $post['user'] = $post['minitutor']['user'];
            $post['user']['avatar'] = AvatarHelper::getUrl($post['user']['avatar']);
            unset($post['minitutor']['user']);

            if(isset($arr['playlist'])) {
                $data['playlist'] = $post;
            } else {
                $data['article'] = $post;
            }

            array_push($response, $data);
        }
        $response = array_values(collect($response)->sortBy('id')->reverse()->toArray());

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
