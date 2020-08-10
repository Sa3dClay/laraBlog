<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
