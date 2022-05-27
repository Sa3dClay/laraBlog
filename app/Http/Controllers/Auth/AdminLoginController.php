<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('guest:admin,admin/home')->except('logout');
    }

    public function redirectTo()
    {
        return 'admin/home';
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function showLoginForm()
    {
        if(Auth::guard('user')->check()) {
            return redirect('home');
        }

        return view('auth.adminlogin');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.loginForm');
    }
}
