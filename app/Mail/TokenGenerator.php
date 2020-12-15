<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Admin;

class TokenGenerator extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $user_type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $user_type)
    {
        $this->email = $email;
        $this->user_type = $user_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $token = Crypt::encrypt($this->generate_code());
        if($this->user_type == 'admin'){
          Admin::add_reset_password_token($this->email, $token, date("Y-m-d H:i:s"));
          return $this->view('mails.reset_password')->subject('LSAPP')->with('token_admin',Crypt::decrypt($token));
        }else{
          User::add_reset_password_token($this->email, $token, date("Y-m-d H:i:s"));
          return $this->view('mails.reset_password')->subject('LSAPP')->with('token_user',Crypt::decrypt($token));
        }
    }

    private function generate_code(){
        $chars = "abcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

}
