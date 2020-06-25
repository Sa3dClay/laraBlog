<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Notification;
use App\Post;
use DB;

class NotificationsController extends Controller
{
  use Queueable;

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
    return view('notifications.index')->with('notifications',auth()->user()->notifications);
  }

  public function send($type,$toWhom_id,$post_id)
  {
    $post = Post::find($post_id);
    $notification = new Notification;
    $message = null;
    if($type == 'like'){
        $message = auth()->user()->name.'has liked your post "';
    }else{
        $message = auth()->user()->name.'has commented on your post "';
    }
    $message +=$post->title.'"';
    $notification->type = $type;
    $notification->user_id = $toWhom_id;
    $notification->post_id = $post_id;
    $notification->message = $message;
    $notification->save();
  }

  public function delete($type,$post_id)
  {
    $notification = DB::table('notifications')->where('post_id', $post_id)
    ->where('user_id', auth()->user()->id)->where('type', $type)->first();
    $notification->delete();
    echo "done";
  }

}
