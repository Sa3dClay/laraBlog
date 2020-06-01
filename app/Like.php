<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // Table Name
    protected $table = 'likes';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function post() {
        return $this->belongsTo('App\Post', 'post_id');
    }
}
