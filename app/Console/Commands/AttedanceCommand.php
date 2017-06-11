<?php

namespace App\Console\Commands;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Console\Command;
use App\Attendance;
class AttedanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:attendance';

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
        $attendace    =   DB::table('attendances')->whereDate('created_at','=' , date("Y-m-d"));
        
        if($attendace->count() > 0){
            foreach($attendace->get() as $check)
            {
               
                if($check->check_in == $check->check_out)
               
                $change = Attendance::findOrFail($check->id);
                $change->check_out = date('Y-m-d H:m:s');
                $change->save();
            }
        }
    }
}