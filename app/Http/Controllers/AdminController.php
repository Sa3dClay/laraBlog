<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\User;
use App\Post;
use App\Http\Controllers\NotificationsController;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('assign.guard:admin,admin/login');
    }

    // home
    public function index()
    {
        return view('adminhome');
    }

    // manage users
    public function listUsers()
    {
        $users = User::all();

        return view('manage.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if( $user->delete() ) {
            return redirect()->back()->with('success', 'user deleted successfully');
        } else {
            return redirect()->back()->with('error', 'an error occurred while deleting user');
        }
    }

    public function blockUser(Request $request) {
        if ($request->user_id && $request->block_until && $request->block_reason)
        {
            $user_id = $request->user_id;
            $block_reason = $request->block_reason;
            $block_until = Carbon::parse($request->block_until);

            if ($block_until->lessThan( now() )) {
                return redirect()->back()->with('error', 'Date is expired');
            }

            $user = User::find($user_id);
            $user->banned_until = $block_until;
            //Notify user
            NotificationsController::send('account block', $user_id, 0); //0 refers to no post/feedback

            if( $user->save() ) {
                return redirect()->back()->with('success', 'User banned successfully');
            } else {
                return redirect()->back()->with('error', 'Failed, something goes wrong!');
            }

        } else {
            return redirect()->back()->with('error', 'Some data is missed');
        }
    }

    public function revokeUser($id)
    {
        $user = User::find($id);
        $user->banned_until = null;
        //Notify user
        NotificationsController::send('account revocation', $id, 0); //0 refers to no post/feedback

        if( $user->save() ) {
            return redirect()->back()->with('success', 'User revoked successfully');
        } else {
            return redirect()->back()->with('error', 'Failed, something goes wrong!');
        }
    }

    // manage posts
    public function listHiddenPosts()
    {
        $posts = Post::orderBy('id', 'desc')->where('hidden','=',1)->get();

        return view('manage.posts', compact('posts'));
    }

    public function hidePost(Request $request)
    {
        if($request->post_id && $request->hide_reason) {
            $post_id = $request->post_id;
            $hide_reason = $request->hide_reason;

            $post = Post::find($post_id);
            $post->hidden = 1;
            //Notify user
            NotificationsController::send('post visibility', $post->user->id, $post_id);

            if( $post->save() ) {
                return redirect('/posts')->with('success', 'Post '.$post_id.' is now hidden');
            } else {
                return redirect()->back()->with('error', 'Failed, something goes wrong!');
            }

        } else {
            return redirect()->back()->with('error', 'Some data is missed');
        }
    }

    public function showPost($id)
    {
        $post = Post::find($id);
        $post->hidden = 0;

        if( $post->save() ) {
            return redirect()->back()->with('success', 'Post '.$id.' is now visible');
        } else {
            return redirect()->back()->with('error', 'Failed, something goes wrong!');
        }
    }
}
