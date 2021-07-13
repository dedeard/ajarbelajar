<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
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
