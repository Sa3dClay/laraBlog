<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);        
        return view('profile')->with('user', $user);
    }

    public function followUser(Request $request){
        $user = User::find($request->user_id);

        $response = Auth::user()->toggleFollow($user);

        $isFollowing = Auth::user()->isFollowing($user);
        
        return response()->json([
            'success'       => $response,
            'isFollowing'   => $isFollowing
        ]);
    }
}
