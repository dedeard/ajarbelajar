<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinitutorResource;
use App\Http\Resources\MinitutorsResource;
use App\Http\Resources\UsersResource;
use App\Models\Minitutor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MinitutorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Cache::remember('minitutors.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            return Minitutor::with('user')
            ->withCount([
                'playlists' => function($q){
                    $q->where('draf', false);
                },
                'articles' => function($q){
                    $q->where('draf', false);
                },
                'subscribers as followers_count'
            ])
            ->where('active', true)
            ->orderByRaw('articles_count + playlists_count  DESC')
            ->orderBy('id')
            ->paginate(12);
        });
        $data->getCollection()->transform(function($item){
            return [
                'user' => UsersResource::make($item->user),
                'minitutor' => MinitutorsResource::make($item),
            ];
        });
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::whereHas('minitutor' , function($q){
            $q->where('active', true);
        })
        ->where('username', $username)
        ->firstOrFail();
        return [
            'user' => UsersResource::make($user),
            'minitutor' => MinitutorResource::make($user->minitutor),
        ];
    }
}
