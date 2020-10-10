<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification_admin extends Model
{
  /// Table Name
  protected $table = 'notifications_admin';
  // there's no primary key ,it's a weak entity

  // Timestamps
  public $timestamps = true;

  public function post() {
      return $this->belongsTo('App\Post', 'post_id');
  }

  public function feedback() {
      return $this->belongsTo('App\Feedback', 'feedback_id');
  }

  //may be used or may not
  public function user() {
      return $this->belongsTo('App\Admin', 'admin_id');
  }
}
