<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $identity = $this->findIdentity();
        $data = $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'string',
            'username' => 'string',
        ]);
        if (Auth::attempt([$identity => $data[$identity], 'password' => $data['password']])) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->accessToken;
            return response()->json(['auth' => AuthResource::make($user), 'token' => $token], 200);
        }
        return response()->json(['message' => __('auth.failed')], 401);
    }

    public function findIdentity()
    {
        $login = request()->input('identity');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login ? strtolower($login) : $login]);
        return $field;
    }
}

