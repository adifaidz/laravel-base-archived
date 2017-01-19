<?php

namespace AdiFaidz\Base\Http\Controllers\Client\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use AdiFaidz\Base\Http\Controllers\Controller;

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
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('base_guest:web_client', ['except' => 'logout']);

        $this->redirectTo = route('client.home');
    }

    public function showLoginForm()
    {
      return view('base::client.auth.login');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->regenerate();

        return redirect()->route('client.login');
    }

    protected function guard()
    {
        return Auth::guard('web_client');
    }
}
