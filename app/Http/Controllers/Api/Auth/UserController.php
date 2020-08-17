<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Rules\Username;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json(UserResource::make($user), 200);
    }

    public function updateAvatar(Request $request)
    {
        $user = $request->user();
        $data = $request->validate(['avatar' => 'required|image|max:4000']);
        $avatar = AvatarHelper::generate($data['avatar'], $user->avatar);
        $user->avatar = $avatar;
        $user->save();
        return response()->json(UserResource::make($user), 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        if($request->input('username')) {
            $request->merge(['username' => strtolower($request->input('username'))]);
        }

        $data = $request->validate([
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users,username,' . $user->id ],
            'email' => ['required', 'string', 'email', 'max:250', 'unique:users,email,' . $user->id ],
            'name' => ['required', 'string', 'max:255'],
            'about' => ['nullable', 'string', 'min:20', 'max:250'],
            'website_url' => ['nullable', 'url', 'max:250'],
            'facebook_url' => ['nullable', 'url', 'max:250'],
            'instagram_url' => ['nullable', 'url', 'max:250'],
            'youtube_url' => ['nullable', 'url', 'max:250'],
            'twitter_url' => ['nullable', 'url', 'max:250'],
            'new_password' => ['nullable', 'string', 'min:8'],
            'password' => ['nullable', 'required_with:new_password', 'password']
        ]);

        if(strtolower($data['email']) !== strtolower($user->email)) {
            $data['email_verified_at'] = null;
        }

        if(isset($data['new_password'])) {
            $data['password'] = Hash::make($data['new_password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json(UserResource::make($user), 200);
    }
}
