<?php

namespace App\Http\Controllers\Api\Account;


use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AuthResource;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function post(Request $request)
    {
        $user = $request->user();
        $data = $request->validate(['avatar' => 'required|image|max:4000']);
        $avatar = AvatarHelper::generate($data['avatar'], $user->avatar);
        $user->avatar = $avatar;
        $user->save();
        return response()->json(AuthResource::make($user), 200);
    }
}
