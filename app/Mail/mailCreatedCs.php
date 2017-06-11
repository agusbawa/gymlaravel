<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\Member;
class mailCreatedCs extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $pass;
   

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$pass)
    {
        //
       $this->email= $email;
      $this->pass = $pass;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $member = Member::where('email',$this->email)->first();
        return $this->view('dashboard.email.csmebercreate')->with('member',$member)->subject('Aktivitas member');
    }
}
