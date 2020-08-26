<?php

namespace App\Http\Controllers\Api\Minitutor;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlaylistResource;
use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'minitutor:active']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $minitutor = $user->minitutor;
        $playlists = $minitutor->playlists();
        return response()->json(PlaylistResource::collection(Playlist::generateQuery($playlists, false, true)->get()), 200);
    }
}
