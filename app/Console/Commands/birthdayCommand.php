<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Console\Command;
use App\Member;


class birthdayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $member    =  Member::where('date_of_birth',Carbon::now('4'));
        if(!is_null($member)){
            foreach($member as $check)
            {
                $msg = App\TemplateEmail::find(3);
                $rep = [':nama'];
                $to = [$member->name];
                $userep = str_replace($rep,$to,$msg->pesan);
                Mail::send('email', [], function ($message) { 
                            $message->to($member->email, $userep)->subject('Infomation');
                }); 
            }
        }
    }
}