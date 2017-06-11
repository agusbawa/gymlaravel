<?php

namespace App\Mail;
use App\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TemplateEmail;
class Birthday extends Mailable
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
        //
       $this->id= $id;
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $msg = TemplateEmail::find('4');
        $member = Member::find($this->id);
        $rep = [':nama'];
        $to = [$member->name];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.birthday')->with('usermsg',$usermsg)->subject('Selamat Ulang Tahun');
    }
}
