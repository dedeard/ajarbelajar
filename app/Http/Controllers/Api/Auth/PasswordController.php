<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Auth\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use DB, Hash, Password;

class PasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware('throttle:30,1')->only('request');
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
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
        return response()->noContent();
    }

    public function request(Request $request)
    {
        $data = $request->validate(['email' => 'required|email|exists:users']);
        $user = User::where('email', $data['email'])->first();
        $user->notify(new ResetPasswordNotification(Password::broker()->createToken($user)));
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
            return response()->noContent();
        } else {
            return response()->json(['message' => __('Unable to reset password.')], 401);
        }
    }
}
