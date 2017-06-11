<?php

namespace App\Mail;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TemplateEmail;
use App\Memeber;
use App\Aktifasi;
class MailAktifasi extends Mailable
{
    use Queueable, SerializesModels;
    public $aktifasi;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($aktifasi)
    {
        //
       $this->aktifasi= $aktifasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = TemplateEmail::find('1');
        $activation = Aktifasi::where('code',$this->aktifasi)->first();
        $member = Member::where('id',$activation->member_id)->first();
       // dd($member);
        $rep = [':code',':email',':password',':nama',':extend',':expire'];
        $to = [$this->aktifasi,$member->email,decrypt($member->password),$member->name,$member->extended_at,$member->expired_at];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.mailcreated')->with('usermsg',$usermsg)->subject('Mail Aktivasi');
    }
}
