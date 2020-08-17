<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:5,1')->only('resend');
    }

    public function verify(Request $request)
    {
        if ($request->route('id') == $request->user()->getKey()) {
            if (!$request->user()->hasVerifiedEmail()) {
                $request->user()->markEmailAsVerified();
                event(new Verified(User::find($request->route('id'))));
                return response()->json(UserResource::make($request->user()), 200);
            } else {
                return response()->json(['message' => __('Your Email Address has previously been verified.')], 422);
            }
        }
        return response()->json(['message' => __('Unable to verify Email')], 400);
    }


    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => __('Your Email Address has previously been verified.')], 422);
        }
        $request->user()->sendMemberEmailVerify();
        return response()->json([], 200);
    }
}
