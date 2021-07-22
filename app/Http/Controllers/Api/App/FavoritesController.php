<?php

namespace App\Http\Controllers\Api\App;

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
        return response()->noContent();
    }

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
        return response()->noContent();
    }
}
