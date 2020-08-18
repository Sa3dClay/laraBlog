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

    //search
    public static function find_no_space($str2 ){
      //if($search_type == 'user'){
        $user_id = auth()->user()->id;
        $user_name = auth()->user()->name;
        $posts = DB::select("SELECT DISTINCT * from posts where user_id = $user_id and (LOWER(title) LIKE '$str2%' or LOWER(category) LIKE '$str2%' or '$str2' = '$user_name') order by posts.created_at desc");
      //}else{
         // $posts_Uids = DB::table('posts')->select('user_id')->get();
         // $user_names = DB::table('users')->whereIn('user.id',$posts_Uids)->select('name')->get();
         // $posts = DB::table('posts')->whereRaw("lower(title) like '$str2%'")
         //          ->orWhereRaw("lower(category) like '$str2%'")
         //          ->orwhereIn("$str2", $user_names)
         //          ->orderBy('posts.created_at' ,'desc')->get();

        //          DB::table('posts')
        //         ->leftjoin('users', 'users.id', '=', 'posts.id')
        //         ->whereRaw("lower(title) like '$str2%'")
        //         ->orWhereRaw("lower(category) like '$str2%'")
        //         ->orWhere('users.name', '=', "$str2")
        //         ->orderBy('posts.created_at' ,'desc')
        //         ->select('posts.id','posts.title','posts.created_at','posts.image_name')->get();
        //   ("SELECT DISTINCT * from posts
        //   JOIN users on users.id = posts.user_id
        //   and LOWER(title) LIKE'$str2%'
        //   or LOWER(category) LIKE'$str2%'
        //   or users.name = '$str2' order by posts.created_at desc");
        //}
      return $posts;
    }

    //search
    public static function find_space($words){
      //if($search_type == 'user'){
        $user_id = auth()->user()->id;
        $user_name = auth()->user()->name;
        $posts = DB::select("SELECT DISTINCT * FROM posts where user_id = $user_id and (LOWER(title) in ($words) or LOWER(category) in ($words) or '$user_name' in ($words)) order by posts.created_at desc");
      // }else{
      //   $posts = DB::select("SELECT DISTINCT * FROM posts JOIN users on users.id = posts.user_id and (LOWER(title) in ($words) or LOWER(category) in ($words) or users.name in ($words)) order by posts.created_at desc");
      // }
      return $posts;
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
}
