<?php

namespace App\Http\Controllers\Web\Auth;

use App\Helpers\Seo;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $intendedURL = Session::get('url.intended');

        if($intendedURL) {
            Session::flash('message', 'Anda harus Login untuk melajutkan.');
        }

        return view('auth.login');
    }
}
