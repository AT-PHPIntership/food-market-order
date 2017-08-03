<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request request check login
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials =  $request->only($this->username(), 'password');
        return array_merge($credentials, ['is_admin' => 1]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request requet login
     * @param  mixed                     $user  user to set active
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $user->is_active = 1;
        $user->save();
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request request logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->is_active = 0;
        $user->save();

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}
