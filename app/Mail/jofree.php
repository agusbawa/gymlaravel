<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\TemplateEmail;
use App\Trialmember;
class jofree extends Mailable
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
         $msg = TemplateEmail::find('11');
        $member = Trialmember::find($this->id);
        $rep = [':email',':tgl_lahir',':telepon',':nama'];
        $to = [$this->email,$member->date_of_birth,$member->phone,$member->name];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.freetrial')->with('usermsg',$usermsg)->subject('Join Ke Member');
    }
}
