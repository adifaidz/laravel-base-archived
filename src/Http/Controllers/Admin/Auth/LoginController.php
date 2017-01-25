<?php

namespace AdiFaidz\Base\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use AdiFaidz\Base\Http\Controllers\Controller;
use AdiFaidz\Base\Traits\LogoutGuardTrait;

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

    use AuthenticatesUsers, LogoutGuardTrait {
        LogoutGuardTrait::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;
    protected $logoutTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('base_guest:web_admin', ['except' => 'logout']);

        $this->redirectTo = route('admin.home');
        $this->logoutTo   = route('admin.login');
    }

    public function showLoginForm()
    {
      return view('base::admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('web_admin');
    }

    protected function broker()
    {
        return Password::broker('users');
    }
}
