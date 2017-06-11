<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Transaction;
use App\TemplateEmail;
use App\Member;
class invoicepembayaran extends Mailable
{
    use Queueable, SerializesModels;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        //
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $transaksi = Transaction::where('code',$this->code)->first();
        $member = Member::where('id',$transaksi->member_id)->first();
        $msg = TemplateEmail::find('5');
        $rep = [':invoice',':email',':tgl_lahir',':telepon',':nama'];
        $to = [$this->code,$member->email,$member->date_of_birth,$member->phone,$member->name];
        $usermsg = str_replace($rep,$to,$msg->pesan);
        return $this->view('dashboard.email.mailcreated')->with('usermsg',$usermsg)->subject('Invoice Pembayaran');
    }
}
