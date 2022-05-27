<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Admin;
use App\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function showResetForm_admin($token){
      $token = base64_encode($token);
       if(Admin::compare_token($token)){
         return view("auth.passwords.reset")->with('token', $token);
       }else{
         return redirect('admin/password/reset')->with('error', "Not valid recovery token, please try again");
       }
    }

    public function changePass_admin(Request $request){
      try{
        $token = $request->input("token");
        $email = Admin::get_email_by_token($token);
        if(isset($email)){
          $admin = Admin::where('email', '=', $email)->first();
          if($admin->email == $email){
            $password = $request->input('password');
             if($password == $request->input('password_confirmation')){
                $admin->password = Hash::make($password);
                $admin->save();
                return redirect('admin/login')->with('success', "Password changed successfully.");
             }else{
                return back()->with('error', "Unmatched passwords!");
             }
          }else{
            return redirect('admin/password/reset')->with('error', "Unmatched email error!");
          }
        }else{
          return redirect('admin/password/reset')->with('error', "Unauthorized token!");
        }
      }catch(\Exception $e){
        return redirect('admin/password/reset')->with('error', "Token invalidation error, please try again");
      }
    }

    public function changePass(Request $request){
      try{
        $token = $request->input("token");
        $email = User::get_email_by_token($token);
        if(isset($email)){
          $user = User::where('email', '=', $email)->first();
          if($user->email == $email){
            $password = $request->input('password');
             if($password == $request->input('password_confirmation')){
                $user->password = Hash::make($password);
                $user->save();
                return redirect('login')->with('success', "Password changed successfully.");
             }else{
                return back()->with('error', "Unmatched passwords!");
             }
          }else{
            return redirect('password/reset')->with('error', "Unmatched email error!");
          }
        }else{
          return redirect('password/reset')->with('error', "Unauthorized token!");
        }
      }catch(\Exception $e){
        return redirect('password/reset')->with('error', "Token invalidation error, please try again");
      }
    }
}
