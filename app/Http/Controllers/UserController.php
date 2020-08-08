<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return view('manage.users', compact('users'));
    }
}
