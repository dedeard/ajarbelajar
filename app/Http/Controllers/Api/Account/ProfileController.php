<?php

namespace App\Http\Controllers\Api\Account;

use App\Helpers\AvatarHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Rules\Username;
use Illuminate\Http\Request;
use Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        return response()->json(["auth" => AuthResource::make($user)], 200);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        if($request->input('username')) {
            $request->merge(['username' => strtolower($request->input('username'))]);
        }
        $data = $request->validate([
            'username' => ['required', 'string', new Username, 'max:64', 'min:6', 'unique:users,username,' . $user->id ],
            'name' => ['required', 'string', 'max:255'],
            'about' => ['nullable', 'string', 'min:20', 'max:250'],
            'website' => ['nullable', 'url', 'max:250'],
            'new_password' => ['nullable', 'string', 'min:8'],
            'password' => ['nullable', 'required_with:new_password', 'password'],
            'email_notification' => ['nullable', 'boolean'],
        ]);
        if(isset($data['new_password'])) {
            $data['password'] = Hash::make($data['new_password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return response()->noContent();
    }
}
