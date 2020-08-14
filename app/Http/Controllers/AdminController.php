<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
