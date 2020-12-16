<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'banned_until'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'banned_until'
    ];

    public function posts() {
        return $this->hasMany('App\Post', 'user_id');
    }

    public function likes() {
        return $this->hasMany('App\Like', 'user_id');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'user_id');
    }

    public function notifications() {
        return $this->hasMany('App\Notification', 'user_id');
    }

    //token to reset email-password
    public static function add_reset_password_token($email, $token, $created_at){
        if(User::check_recent_resets($email)){
          DB::update("update password_resets
           SET token = '$token', created_at = '$created_at' where email = '$email'");
        }else{
          DB::insert("insert into password_resets(email, token, created_at)
           values (?,?,?)", [$email, $token, $created_at]);
        }
    }
    private static function check_recent_resets($email){
        $result = DB::select("select * from password_resets where email = '$email'");
        if(sizeof($result) > 0){
          return true;
        }
        return false;
    }
    //compare url_token
    public static function compare_token($hashed_token){
        $result = DB::select("select * from password_resets where token = '$hashed_token'");
        if(sizeof($result) > 0){
          return true;
        }
        return false;
    }

    public static function get_email_by_token($token){
      $result = DB::table('password_resets')->select('email')->where('token', '=', $token)->first();
      return $result->email;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // delete owned posts with its activities
            $user->posts()->delete();
            // delete activities on other users posts
            $user->likes()->delete();
            $user->comments()->delete();
            $user->notifications()->delete();
        });
    }
}
