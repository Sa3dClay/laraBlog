<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
  // Table Name
  protected $table = 'notifications';
  // there's no primary key ,it's a weak entity

  // Timestamps
  public $timestamps = true;

  public function post() {
      return $this->belongsTo('App\Post', 'post_id'); //key used post_id
  }

  //may be used or may not
  public function user() {
      return $this->belongsTo('App\User', 'user_id');
  }

  public static function isTherenew(){
    if(!auth()->guest()){
      $note = Notification::where([['user_id','=', auth()->user()->id],['created_at','=','updated_at']])->first();
      if(!empty($note)){
          session(['new_notif' => 'true']);
      }
    }
  }
}
