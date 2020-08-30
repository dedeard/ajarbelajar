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
        $data = $user->subscriptions()
        ->withType(Minitutor::class)
        ->with(['minitutor' => function($q){
            $q->with(['user']);
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
}
