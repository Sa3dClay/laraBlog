<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class PagesController extends Controller
{

    public function index () {
        $title = 'Home';
        Notification::isTherenew();
        return view('pages.index', compact('title'));
        /* another way to do that */
        //return view('pages.index')->with('title', $title);
    }

    public function about () {
    	return view('pages.about');
    }

}
