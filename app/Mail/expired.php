<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TemplateEmail;
use App\Member;
class expired extends Mailable
{
    use Queueable, SerializesModels;
    public $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = TemplateEmail::find('7');
         
        $member = Member::find($this->id);
        $rep = [':nama',':email',':expire'];
        $to = [$member->name,$member->email,date("d M Y", strtotime($member->expired_at))];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.birthday')->with('usermsg',$usermsg)->subject('Expire Member');
    }
}
