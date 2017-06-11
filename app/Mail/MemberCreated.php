<?php

namespace App\Mail;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TemplateEmail;
use App\Transaction;
class MemberCreated extends Mailable
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
        $msg = TemplateEmail::find('2');
        $member = Member::where('email',$this->email)->first();
         $transaksi = Transaction::orderBy('created_at','desc')->where('member_id',$member->id)->first();
        $rep = [':email',':password',':nama',':extend',':expire :invoice'];
        $to = [$this->email,decrypt($this->pass),$member->name,$member->extended_at,$member->expired_at,$transaksi->code];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.mailcreated')->with('usermsg',$usermsg)->subject('Member Hawa gym');
    }
}
