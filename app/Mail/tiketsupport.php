<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class tiketsupport extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $pesan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$pesan)
    {
        //
        $this->email = $email;
        $this->pesan = $pesan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $msg = TemplateEmail::find('12');
        $member = Trialmember::where('email',$this->email)->first();
        $rep = [':email',':tgl_lahir',':telepon',':nama'];
        $to = [$this->email,$member->date_of_birth,$member->phone,$member->name];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.tiketsuport')->with('usermsg',$usermsg)->with('pesan',$pesan)->subject('Tiket Support');
    }
}
