<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Playlist;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
