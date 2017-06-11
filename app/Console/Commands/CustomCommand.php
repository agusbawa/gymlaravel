<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Console\Command;

class CustomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:command';

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
        $members    =   DB::table('members')->get();
            foreach ($members as $member) {
                $member_date = $member->expired_at;
                $member_email = $member->email;
                $now  = Carbon::parse(Carbon::now());
                $end  = Carbon::parse($member_date);
                $range_date = $end->diffInDays($now);
                $msg = App\TemplateEmail::find('3');
                $rep = [':nama',':expire'];
                $to = [$member->name,$member_date];
                $userep = str_replace($rep,$to,$msg->pesan);
                    if ($range_date >= 14 || $range_date >= 7 || $range_date >= 1 ){
                        Mail::send('email', [], function ($message) { 
                            $message->to($member_email, $userep)->subject('Infomation');
                        });
                    }
            }
    }
}