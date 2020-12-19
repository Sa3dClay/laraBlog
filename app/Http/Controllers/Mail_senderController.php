<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TokenGenerator;
use Mail;
use App\User;
use App\Admin;

class Mail_senderController extends Controller
{
    private $receiver;
    private $user_type;

    public function __construct(){
        //
    }

    public function send_pass_link(Request $request){
        try {
            $email = $request->input('email');

            if($this->check_email($email)){
                Mail::to($this->receiver)->send(new TokenGenerator($email, $this->user_type));
                
                if(Mail::failures()) {
                    return back()->with('error',"Can't send the requested mail!");
                } else {
                    return back()->with('success','mail was sent successfully, check your email!');
                }

            } else {
                return back()->with('error',"Can't find the requested email!");
            } 
        } catch(\Swift_TransportException $e) {
            return back()->with('error', "Can't connect google mail due to SMPT autentication error, please contact us via (paystoreoss@gmail.com).");
        }
    }

    private function check_email($email) {
        if(strpos(url()->current(), 'admin/') !== false) {
            $admin = Admin::Where('email', '=', $email)->get();
            
            if(sizeof($admin) > 0) {
                $this->receiver = $admin;
                $this->user_type = 'admin';
                return true;
            }
        } else {
            $user = User::Where('email', '=', $email)->get();
            
            if(sizeof($user) > 0) {
                $this->receiver = $user;
                $this->user_type = 'user';
                return true;
            }
        }
        return false;
    }
}
