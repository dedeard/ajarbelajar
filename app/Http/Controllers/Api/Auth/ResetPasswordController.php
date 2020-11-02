<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware('throttle:30,1')->only('request');
    }

    public function check(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');

        $expiredAt = config('auth.passwords.users.expire')*60;
        $data = DB::table('password_resets')->where('email', '=', $email)->first();

        if (!$data) {
            return response()->json(["message" => __('Unable to reset password.')], 401);
        }

        if(Carbon::parse($data->created_at)->addSeconds($expiredAt)->isPast()) {
            return response()->json(["message" => __('Unable to reset password.')], 401);
        }

        if(!Hash::check($token, $data->token)) {
            return response()->json(["message" => __('Unable to reset password.')], 401);
        }

        return response()->json([], 200);
    }

    public function request(Request $request)
    {
        $data = $request->validate(['email' => 'required|string|exists:users']);
        $user = User::where('email', $data['email'])->first();
        $user->sendMemberEmailResetPassword();
        return response()->json(["message" => __('We have sent a Password Reset Email to your Email.')], 200);
    }

    public function update(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if($response == Password::PASSWORD_RESET){
            return response()->json([], 200);
        } else {
            return response()->json(['message' => __('Unable to reset password.')], 401);
        }
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }
}
