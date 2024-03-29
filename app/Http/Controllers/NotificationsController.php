<?php

namespace App\Http\Controllers;

use App\Post;
use App\Feedback;
use App\Notification;
use App\NotificationAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\NotificationResource;

class NotificationsController extends Controller
{
    public function __construct()
    {
        //$this->middleware(['web'])->only('index_userN_api'); //web is the default middleware for all methods
        // then we should make a develop a middleware for api authentication
    }

    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $notifications = NotificationAdmin::orderBy('created_at', 'desc')->get();
        } else {
            $notifications = Notification::where('user_id', '=', auth()->user()->id)->orderBy('created_at', 'desc')->get();
            // $notifications = auth()->user()->notifications;
        }

        $this->mark_last_view();

        // if(strpos(url()->current(),"api")!==false){ //for the api
        //     return NotificationResource::collection($notifications);
        // }

        return view('notifications.index')->with('notifications', $notifications);
        //return response()->json(['notifications'=> $notifications]);
    }

    // post_id or feedback_id for user ONLY
    public static function send($type, $toWhom_id, $post_id, $added_message = null)
    {
        $notification = new Notification;
        $message = null;

        if (Auth::guard('admin')->check()) { // admin notes

            if (strpos($type, 'hidden') !== false) {
                if ($type == 'hidden post') {
                    $message = "Your post '" . Post::find($post_id)->title . "' has been hidden for (" . $added_message . ")";
                } else {
                    $message = "Your post '" . Post::find($post_id)->title . "' has been revoked!";
                }

            } elseif (strpos($type, 'account') !== false) {
                if ($type == 'account block') {
                    // in case of account block, $post_id won't refer to nothing (0)
                    $message = "Your account has been temporarily blocked for (" . $added_message . ")";
                } else {
                    // in case of account revocation, $post_id won't refer to nothing (0)
                    $message = "Your account has been revoked successfully.";
                }

            } else { // else if(strpos($type, 'feedback') !== false){
                $feedback_title = Feedback::find($post_id)->title;

                if ($type == 'feedback closure') {
                    $message = "Your feedback " . '"' . $feedback_title . '"' . " has been closed";
                    
                } else {
                    //feedback response
                    $message = "You got a response for your problem " . '"' . $feedback_title . '"';
                }
            }

            $notification->type = $type;
            $notification->user_id = $toWhom_id;
            $notification->post_id = $post_id; // or feedback_id

        } else { // user notes
            if (strpos($type, 'new ') !== false) {
                $notification_admin = new NotificationAdmin;

                if ($type == 'new feedback') {
                    $message = "New feedback has just arrived!";
                    $notification_admin->feedback_id = $post_id; // feedback_id
                } else { //new post
                    $message = "New post has just been written.";
                    $notification_admin->post_id = $post_id;
                }

                $notification_admin->type = $type;
                $notification_admin->message = $message;

                $notification_admin->save();
                return 0;

                // $notification->admin_id = $toWhom_id; // $toWhom_id won't be used because notification will be sent to all admins
            } else {
                $post = Post::find($post_id);

                if ($type == 'like') {
                    $message = auth()->user()->name . ' has liked your post "';
                } else {
                    $message = auth()->user()->name . ' has commented on your post "';
                }

                $message .= $post->title . '"';
                $notification->user_id = $toWhom_id;
                $notification->post_id = $post_id; // or feedback_id
            }

            $notification->type = $type;
        }

        $notification->message = $message;

        $notification->save();
    }

    public static function delete($type, $post_id, $date) // date is used to delete the specified notification
    {
        if (Auth::guard('admin')->check()) {
            if ($type == 'new feedback') {
                $notification = NotificationAdmin::where([
                    ['feedback_id', '=', $post_id], // in case of new-feedback type
                    ['type', '=', $type],
                    ['created_at', '=', $date],
                ])->delete();

            } else { //new post
                $notification = Notification::where([
                    ['post_id', '=', $post_id],
                    ['type', '=', $type],
                    ['created_at', '=', $date],
                ])->delete();
            }

        } else {
            if ($type == 'comment') {
                $notification = Notification::where([
                    ['post_id', '=', $post_id],
                    ['user_id', '=', auth()->user()->id],
                    ['type', '=', $type],
                    ['created_at', '=', $date],
                ])->delete();

            } else if ($type == 'like') {
                $notification = Notification::where([
                    ['post_id', '=', $post_id],
                    ['user_id', '=', auth()->user()->id],
                    ['type', '=', $type],
                ])->delete();
            }
        }

        //$notification->delete();
        //not working because it compares the primary key id automatically but it doesn't exist
    }

    private function mark_last_view()
    {
        if (Auth::guard('admin')->check()) {
            NotificationAdmin::where('post_id', '=', 0)->orWhere('feedback_id', '=', 0)
                ->update(array('updated_at' => date("Y-m-d H:i:s"))); // update all rows

        } else {
            //Session::forget('new_notif');
            //session()->forget('new_notif');

            Notification::where([['user_id', '=', auth()->user()->id]])->update(array('updated_at' => date("Y-m-d H:i:s")));
        }
    }

    public function isThereNew(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $note = NotificationAdmin::whereColumn('created_at', '=', 'updated_at')->first();

        } else {
            $note = Notification::whereColumn('created_at', '=', 'updated_at')
                ->where('user_id', '=', auth()->user()->id)->first();
        }

        return response()->json(['new_notif' => $note]);
    }

    public function get_new_Notif(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            $newNots = NotificationAdmin::whereColumn('created_at', '=', 'updated_at')
                ->orderBy('created_at', 'desc')->get();

        } else {
            $newNots = Notification::whereColumn('created_at', '=', 'updated_at')
                ->where('user_id', '=', auth()->user()->id)
                ->orderBy('created_at', 'desc')->get();
        }

        $this->mark_last_view();

        return response()->json(['newNots' => $newNots]);
    }

    public function index_userN_api($user_id)
    { //for user ONLY
        $notifications = Notification::where('user_id', '=', $user_id)->orderBy('created_at', 'desc')->get();

        //$notifications = auth()->user()->notifications;

        return NotificationResource::collection($notifications);
    }
}
