<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->likes()->delete();
            $post->comments()->delete();
        });
    }
}
