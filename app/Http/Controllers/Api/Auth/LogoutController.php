<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function logout(Request $request)
    {
        $request->user()->clearApiToken();
        return response()->json([], 200);
    }
}
