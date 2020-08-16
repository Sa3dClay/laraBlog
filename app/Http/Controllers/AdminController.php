<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('assign.guard:admin,admin/login');
    }

    public function index()
    {
        return view('adminhome');
    }

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

        if( $user->save() ) {
            return redirect()->back()->with('success', 'User revoked successfully');
        } else {
            return redirect()->back()->with('error', 'Failed, something goes wrong!');
        }
    }
}
