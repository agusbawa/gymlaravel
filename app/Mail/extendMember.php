<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\TemplateEmail;
use \App\Member;
class extendMember extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        //
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = TemplateEmail::find('6');
        $member = Member::where('email',$this->email)->first();
        $rep = [':email',':password',':expire',':extend',':nama'];
        $to = [$this->email,decrypt($member->password),$member->expired_at,$member->extended_at,$member->name];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.extendmember')->with('usermsg',$usermsg)->subject('Perpanjang Member');
    }
}
