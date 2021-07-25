<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request, $minitutor_id)
    {
        $user = $request->user();
        $minitutor = Minitutor::where('active', true)->findOrFail($minitutor_id);
        if(!$user->followings()->where('minitutor_id', $minitutor_id)->exists()) {
            Follow::create(['user_id' => $user->id, 'minitutor_id' => $minitutor->id]);
        }
        return response()->json(['minitutor_id' => $minitutor->id], 200);
    }

    public function destroy(Request $request, $minitutor_id)
    {
        $user = $request->user();
        $minitutor = Minitutor::where('active', true)->findOrFail($minitutor_id);
        Follow::where('user_id', $user->id)->where('minitutor_id', $minitutor->id)->delete();
        return response()->noContent();
    }
}
