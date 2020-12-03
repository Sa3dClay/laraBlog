<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    // Table name
    protected $table = 'Responses';
    // there's no primary key ,it's a weak entity
    // Timestamps
    public $timestamps = true;

    public function feedback() {
        return $this->belongsTo('App\Feedback', 'feedback_id'); //key used post_id
    }

    public function admin() {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
