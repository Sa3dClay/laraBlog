<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Http\Resources\Notification_resource;
use App\Notification;
use App\Post;
use App\Feedback;
use DB;

class NotificationsController extends Controller
{
    use Queueable;

    public function __construct()
    {
        $this->middleware(['web'])->only('index_userN_api');
        // then we should make a develop a middleware for api authentication
    }

    public function index()
    {
        $notifications = Notification::where('user_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->get();
        // $notifications = auth()->user()->notifications;

        $this->mark_last_view();
        // if(strpos(url()->current(),"api")!==false){ //for the api
        //     return Notification_resource::collection($notifications);
        // }

        return view('notifications.index')->with('notifications',$notifications);
        //return response()->json(['notifications'=> $notifications]);
    }

    public static function send($type, $toWhom_id, $post_id) // post_id or feedback_id
    {
        $notification = new Notification;
        $message = null;
        if(strpos($type, 'account') !== false){
          if($type == 'account block'){
            //in case of account block, $post_id won't refer to nothing (0)
            $message = "Your account has been temporarily blocked!" ;
          }else{
            //in case of account revocation, $post_id won't refer to nothing (0)
            $message = "Your account has been revoked successfully.";
          }

        }else if(strpos($type, 'feedback') !== false){
          $feedback_title = Feedback::find($post_id)->title;

          if($type == 'feedback closure'){
              $message = "Your feedback ". '"'. $feedback_title .'"' ." has been closed";
          }else{
              //feedback response
              $message = "You got a response for your problem ". '"'. $feedback_title . '"';
          }

        }else{
          $post = Post::find($post_id);

          if($type == 'like'){
              $message = auth()->user()->name.' has liked your post "';
          }else{
              $message = auth()->user()->name.' has commented on your post "';
          }
          $message .= $post->title.'"';
        }
        $notification->type = $type;
        $notification->user_id = $toWhom_id;
        $notification->post_id = $post_id; // or feedback_id
        $notification->message = $message;
        $notification->save();
    }

    public static function delete($type, $post_id, $date)
    {
        if($type == 'comment') {
            $notification = Notification::where([
                ['post_id','=', $post_id],
                ['user_id','=', auth()->user()->id],
                ['type','=', $type],
                ['created_at','=',$date]
            ])->delete();

        } else if($type == 'like'){
            $notification = Notification::where([
                ['post_id','=', $post_id],
                ['user_id','=', auth()->user()->id],
                ['type','=', $type]
            ])->delete();
        }

        //$notification->delete();
        //not working because it compares the primary key id automatically but it doesn't exist
    }

    private function mark_last_view()
    {
        //Session::forget('new_notif');
        //session()->forget('new_notif');

        Notification::where([['user_id','=',auth()->user()->id]])->update(array('updated_at' => date("Y-m-d H:i:s")));
    }

    public function isThereNew(Request $request){
        if(!auth()->guest()){
            $note = Notification::whereColumn('created_at','=','updated_at')
                ->where('user_id','=', auth()->user()->id)->first();
            return response()->json(['new_notif'=>$note]);
        }

        return response()->json(['new_notif'=>'']);
    }

    public function get_new_Notif(Request $request){
        $newNots = Notification::whereColumn('created_at','=','updated_at')
            ->where('user_id','=', auth()->user()->id)
            ->orderBy('created_at', 'desc')->get();
        $this->mark_last_view();

        return response()->json(['newNots'=>$newNots]);
    }

    public function index_userN_api($user_id){
        $notifications = Notification::where('user_id','=',$user_id)->orderBy('created_at', 'desc')->get();
        //$notifications = auth()->user()->notifications;

        return Notification_resource::collection($notifications);
    }
}
