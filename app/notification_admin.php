<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification_admin extends Model
{
    protected $table = 'notifications_admin';
    // there's no primary key, it's a weak entity

    // Timestamps
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function feedback()
    {
        return $this->belongsTo('App\Feedback', 'feedback_id');
    }

    // Notification will be sent to all admins
    /* public function user() {
        return $this->belongsTo('App\Admin', 'admin_id');
    } */
}
