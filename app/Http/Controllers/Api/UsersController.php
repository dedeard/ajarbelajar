<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = Cache::remember('users.page.' . $request->input('page') ?? 1, config('cache.age'), function () {
            return User::orderBy('points', 'desc')->orderBy('id')->paginate(20);
        });
        return UsersResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->orWhere('username', $id)->firstOrFail();
        return UserResource::make($user);
    }

    public function mostPoints()
    {
        $users = Cache::remember('users.most.points', config('cache.age'), function () {
            return User::select(['id', 'username', 'points', 'avatar', 'name', 'created_at', 'updated_at'])->orderBy('points', 'desc')->limit(4)->get();
        });
        return UsersResource::collection($users);
    }
}
