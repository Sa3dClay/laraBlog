<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
  protected $table = 'feedbacks';
  public $primaryKey = 'id';
  // Timestamps
  public $timestamps = true;

  public function user() {
      return $this->belongsTo('App\User', 'user_id');
  }
  public function notifications() {
      return $this->hasMany('App\Notification', 'feedback_id');
  }
}
