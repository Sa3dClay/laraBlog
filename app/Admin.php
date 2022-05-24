<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //token to reset email-password
    public static function add_reset_password_token($email, $token, $created_at){
        if(Admin::check_recent_resets($email)){
          DB::update("update admin_password_resets
           SET token = '$token', created_at = '$created_at' where email = '$email'");
        }else{
          DB::insert("insert into admin_password_resets(email, token, created_at)
           values (?,?,?)", [$email, $token, $created_at]);
        }
    }
    private static function check_recent_resets($email){
        $result = DB::select("select * from admin_password_resets where email = '$email'");
        if(sizeof($result) > 0){
          return true;
        }
        return false;
    }
    //compare url_token
    public static function compare_token($hashed_token){
        $result = DB::select("select * from admin_password_resets where token = '$hashed_token'");
        if(sizeof($result) > 0){
          return true;
        }
        return false;
    }

    public static function get_email_by_token($token){
      $result = DB::table('admin_password_resets')->select('email')->where('token', '=', $token)->first();
      return $result->email;
    }

}
