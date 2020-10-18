<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Minitutor;
use App\Models\Playlist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::select(['id', 'username', 'avatar', 'name', 'created_at', 'updated_at'])->orderBy('id', 'desc')->get();
        $users = [];
        foreach($data as $user) {
            $arr = $user->toArray();
            $arr['avatar'] = AvatarHelper::getUrl($arr['avatar']);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            array_push($users, $arr);
        }
        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::select([
            'id',
            'name',
            'avatar',
            'points',
            'about',
            'website_url',
            'twitter_url',
            'facebook_url',
            'instagram_url',
            'youtube_url',
            'username',
            'created_at',
            'updated_at'
        ])
        ->with(['minitutor' => function($q){
            $q->select(['id', 'user_id', 'active']);
        }])
        ->withCount(['subscriptions as favorites_count' => function($q){
            $q->where('subscribable_type', Article::class)
            ->orWhere('subscribable_type', Playlist::class);
        }, 'subscriptions as followings_count' => function($q){
            $q->where('subscribable_type', Minitutor::class);
        }]);

        if(is_numeric($id)) {
            $user = $user->findOrFail($id);
        } else {
            $user = $user->where('username', $id)->firstOrFail();
        }

        $arr = $user->toArray();
        $arr['avatar'] = AvatarHelper::getUrl($arr['avatar']);
        $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
        $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
        $arr['minitutor'] = (Bool) $arr['minitutor'];

        return $arr;
    }

    public function mostPoints()
    {
        $data = User::select(['id', 'username', 'points', 'avatar', 'name', 'created_at', 'updated_at'])->orderBy('points', 'desc')->limit(4)->get();
        $users = [];
        foreach($data as $user) {
            $arr = $user->toArray();
            $arr['avatar'] = AvatarHelper::getUrl($arr['avatar']);
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            array_push($users, $arr);
        }
        return $users;
    }
}
