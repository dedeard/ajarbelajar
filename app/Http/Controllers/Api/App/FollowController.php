<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Models\Minitutor;
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
        if(!$user->hasSubscribed($minitutor)) $user->subscribe($minitutor);
        return response()->json(['minitutor_id' => $minitutor->id], 200);
    }

    public function destroy(Request $request, $minitutor_id)
    {
        $user = $request->user();
        $minitutor = Minitutor::where('active', true)->findOrFail($minitutor_id);
        if($user->hasSubscribed($minitutor)) $user->unsubscribe($minitutor);
        return response()->noContent();
    }
}
