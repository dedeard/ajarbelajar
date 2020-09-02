<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'followers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);
        $data = $user->subscriptions()
        ->withType(Minitutor::class)
        ->with(['minitutor' => function($q){
            $q->select([
                'id',
                'user_id',
                'active',
                'last_education',
                'majors',
                'university',
                'city_and_country_of_study'
            ]);
            $q->with(['user' => function($q){
                $q->select([
                    'id',
                    'username',
                    'name',
                    'avatar',
                    'points',
                    'website_url',
                    'twitter_url',
                    'facebook_url',
                    'instagram_url',
                    'youtube_url',
                ]);
            }]);
            $q->withCount(['playlists' => function($q){
                $q->where('draf', false);
            },'articles' => function($q){
                $q->where('draf', false);
            }, 'subscriptions as followers_count']);
        }])
        ->whereHas('minitutor', function($q){
            $q->where('active', true);
        })
        ->get();

        $response = [];
        foreach($data->toArray() as $arr) {
            $arr['created_at'] = Carbon::parse($arr['created_at'])->timestamp;
            $arr['updated_at'] = Carbon::parse($arr['updated_at'])->timestamp;
            $arr['user'] = $arr['minitutor']['user'];
            $arr['user']['avatar'] = AvatarHelper::getUrl($arr['user']['avatar']);
            unset($arr['minitutor']['user']);
            array_push($response, $arr);
        }
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $minitutor_id)
    {
        $user = $request->user();
        $minitutor = Minitutor::where('active', true)->findOrFail($minitutor_id);
        if(!$user->hasSubscribed($minitutor)) $user->subscribe($minitutor);
        return response()->json(['minitutor_id' => $minitutor->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $minitutor_id)
    {
        $user = $request->user();
        $minitutor = Minitutor::where('active', true)->findOrFail($minitutor_id);
        if($user->hasSubscribed($minitutor)) $user->unsubscribe($minitutor);
        return response()->json([], 200);
    }

    public function followers($minitutor_id) {
        $minitutor = Minitutor::where('active', true)->findOrFail($minitutor_id);
        $response = [];
        foreach ($minitutor->subscribers as $user) {
            array_push($response, [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' =>  AvatarHelper::getUrl($user->avatar),
                'points' => $user->points,
                'username' => $user->username,
                'website_url' => $user->website_url,
                'twitter_url' => $user->twitter_url,
                'facebook_url' => $user->facebook_url,
                'instagram_url' => $user->instagram_url,
                'youtube_url' => $user->youtube_url,
                'created_at' => $user->created_at->timestamp,
                'updated_at' => $user->updated_at->timestamp,
            ]);
        };
        return $response;
    }
}
