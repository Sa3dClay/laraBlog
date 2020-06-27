<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Notification;
use App\Post;
use DB;
//use Illuminate\Support\Facades\Auth;
//use Session;

class NotificationsController extends Controller
{
  use Queueable;

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
    //$this->mark_last_view();
    $notifications = auth()->user()->notifications;
    $this->mark_last_view();
    return view('notifications.index')->with('notifications',$notifications);
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
    $notification = Notification::where([['post_id','=', $post_id]
    ,['user_id','=', auth()->user()->id],['type','=', $type]])->first();
    $notification->delete();
    echo "done";
  }

  private function mark_last_view(){
      //Session::forget('new_notif');
      session()->forget('new_notif');
      Notification::where([['user_id','=',auth()->user()->id]])->update(array('updated_at' => date("Y-m-d H:i:s")));
  }

}
