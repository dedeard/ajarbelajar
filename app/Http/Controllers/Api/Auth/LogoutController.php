<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens->each(function($token, $key) {
            $token->delete();
        });
        return response()->json([], 200);
    }
}
