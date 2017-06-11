<?php

namespace App\Mail;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class PromoMail extends Mailable
{
    use Queueable, SerializesModels;
    public $msg;
    public $subject;
    public $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg,$subject,$id)
    {
        //
    $this->subject = $subject;
    $this->msg = $msg;
    $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $member=Member::find($this->id);
         $rep = [':email',':password',':expire',':extend',':nama'];
        $to = [$this->email,decrypt($member->password),$member->expired_at,$member->extended_at,$member->name];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.PromoMail')->with('msg',$usermsg)->subject($this->subject);
    }
}
