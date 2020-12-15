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

    public static function add_reset_password_token($email, $token, $created_at){
        DB::insert("insert into password_resets(email, token, created_at) values (?,?,?)", [$email, $token, $created_at]);
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
