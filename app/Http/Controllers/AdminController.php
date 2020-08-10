<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    // constructor

    public function index()
    {
        return view('adminhome');
    }

    public function listUsers()
    {
        $users = User::all();

        return view('manage.users', compact('users'));
    }
}
