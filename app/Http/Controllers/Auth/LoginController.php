<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user,home')->except('logout');
    }

    public function redirectTo()
    {
        return 'home';
    }

    protected function guard()
    {
        return \Auth::guard('user');
    }

    public function showLoginForm()
    {
        if(Auth::guard('admin')->check()) {
            return redirect('admin/home');
        }

        return view('auth.login');
    }
}
