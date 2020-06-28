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
    $notifications = auth()->user()->notifications;
    $this->mark_last_view();
    return view('notifications.index')->with('notifications',$notifications);
  }

  public static function send($type,$toWhom_id,$post_id)
  {
    $post = Post::find($post_id);
    $notification = new Notification;
    $message = null;
    if($type == 'like'){
        $message = auth()->user()->name.' has liked your post "';
    }else{
        $message = auth()->user()->name.' has commented on your post "';
    }
    $message .= $post->title.'"';
    $notification->type = $type;
    $notification->user_id = $toWhom_id;
    $notification->post_id = $post_id;
    $notification->message = $message;
    $notification->save();
  }

  public static function delete($type,$post_id,$date)
  {
    if($type == 'comment'){
      $notification = Notification::where([['post_id','=', $post_id]
      ,['user_id','=', auth()->user()->id],['type','=', $type],['created_at','=',$date]])->delete();
    }else if($type == 'like'){
      $notification = Notification::where([['post_id','=', $post_id]
      ,['user_id','=', auth()->user()->id],['type','=', $type]])->delete();
    }
    //$notification->delete();
    //not working because it compares the primary key id automatically but it doesn't exist
  }

  private function mark_last_view(){
      //Session::forget('new_notif');
      //session()->forget('new_notif');
      Notification::where([['user_id','=',auth()->user()->id]])->update(array('updated_at' => date("Y-m-d H:i:s")));
  }

  public function isThereNew(Request $request){
    if(!auth()->guest()){
       $note = Notification::whereColumn('created_at','=','updated_at')->where('user_id','=', auth()->user()->id)->first();
        return response()->json(['new_notif'=>$note]);
    }
    return response()->json(['new_notif'=>'']);
  }

}
