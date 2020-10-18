<?php

namespace App\Http\Controllers\api;

use App\Helpers\AvatarHelper;
use App\Helpers\HeroHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Minitutor;
use App\Models\Playlist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MinitutorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::select([
            'id',
            'username',
            'name',
            'avatar',
            'points',
            'about',
            'website_url',
            'twitter_url',
            'facebook_url',
            'instagram_url',
            'youtube_url',
        ])
        ->with(['minitutor' => function($q){
            $q->select([
                'id',
                'user_id',
                'active',
                'last_education',
                'majors',
                'university',
                'city_and_country_of_study',
                'interest_talent',
            ]);
            $q->withCount([
                'playlists' => function($q){
                    $q->where('draf', false);
                },
                'articles' => function($q){
                    $q->where('draf', false);
                },
                'subscribers as followers_count'
            ]);
        }])->whereHas('minitutor' , function($q){
            $q->where('active', true);
        })->get();

        $response = [];
        foreach($data->toArray() as $arr) {
            $minitutor = $arr['minitutor'];
            unset($arr['minitutor']);
            $arr = [ 'user' => $arr, 'minitutor' => $minitutor ];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            array_push($response, $arr);
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function articles($id)
    {
        $user = User::whereHas('minitutor', function($q){
            $q->where('active', true);
        });

        if(is_numeric($id)) {
            $user = $user->findOrFail($id);
        } else {
            $user = $user->where('username', $id)->firstOrFail();
        }

        $articles = Article::generateQuery($user->minitutor->articles())->get()->toArray();
        $response = [];
        foreach($articles as $article) {
            $arr = $article;
            $arr['hero'] = HeroHelper::getUrl($arr['hero'] ? $arr['hero']['name'] : null);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            $arr['rating'] = round($arr['rating'], 2);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return $response;
    }

    public function playlists($id)
    {
        $user = User::whereHas('minitutor', function($q){
            $q->where('active', true);
        });

        if(is_numeric($id)) {
            $user = $user->findOrFail($id);
        } else {
            $user = $user->where('username', $id)->firstOrFail();
        }

        $playlists = Playlist::generateQuery($user->minitutor->playlists())->get()->toArray();
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
        return $response;
    }
}
