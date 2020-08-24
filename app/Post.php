<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Post extends Model
{
    // Table Name
    protected $table = 'posts';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function likes() {
        return $this->hasMany('App\Like', 'post_id');
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable')->whereNull('parent_id');
    }

    public function notifications() {
        return $this->hasMany('App\Notification', 'post_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->likes()->delete();
            $post->comments()->delete();
            $post->notifications()->delete();
        });
    }

    // search
    public static function find_no_space($str2) {
        $user_id = auth()->user()->id;
        $user_name = strtolower(auth()->user()->name);

        $posts = DB::select("SELECT DISTINCT * from posts where user_id = $user_id and (lower(replace(title,' ','')) LIKE '%$str2%' or lower(replace(category,' ','')) LIKE '%$str2%' or '$str2' = '$user_name') order by posts.created_at desc");

        return $posts;
    }

    // search
    public static function find_space($words){
        $user_id = auth()->user()->id;
        $user_name = strtolower(auth()->user()->name);

        $posts = DB::select("SELECT DISTINCT * FROM posts where user_id = $user_id and (lower(replace(title,' ','')) in ($words) or lower(replace(category,' ','')) in ($words) or '$user_name' in ($words)) order by posts.created_at desc");

        return $posts;
    }
}
