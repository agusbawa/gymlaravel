<?php

namespace App\Http\Controllers;
use App\Attendance;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Member;
use App\TemplateEmail;
use App\Mail\Birthday;
use App\Mail\willexpired;
use App\Mail\expired;
use App\Mail\jofree;
class cronjobController extends Controller
{
    //
    public function autocheckout()
    {
        # code...
         $attendace    =   DB::table('attendances')->whereDate('created_at','=' , date("Y-m-d"));
        
        if($attendace->count() > 0){
            foreach($attendace->get() as $check)
            {
               
                if($check->check_in == $check->check_out){
               
                $change = Attendance::findOrFail($check->id);
               
                $change->check_out = Carbon::now();
                $change->save();
            }
        }
    }
    }
    public function birthday()
    {
       $member    =  Member::whereMonth('date_of_birth',Carbon::today()->month)->whereDay('date_of_birth',Carbon::today()->day);
       
        if(!is_null($member)){
            foreach($member->get() as $check)
            {
                
                Mail::to($check->email)->send(new Birthday($check->id)); 
            }
        }
    }
    public function custom()
    {
       $members    =   DB::table('members')->get();
            foreach ($members as $member) {
                $member_date = $member->expired_at;
                $member_email = $member->email;
                $now  = Carbon::parse(Carbon::now()->format('Y-m-d'));
                $end  = Carbon::parse($member_date);
                $range_date = $end->diffInDays($now);
                    if ($member_date > Carbon::now()->format('Y-m-d')){
                        if ($range_date == 14 || $range_date == 7 || $range_date == 1 ){     
                            Mail::to($member->email)->send(new willexpired($member->id)); 
                        }
                    }
            }
    }
     public function expire()
    {
       $members    =   DB::table('members')->get();
            foreach ($members as $member) {
                $member_date = $member->expired_at;
                $member_email = $member->email;
                $now  = Carbon::parse(Carbon::now());
                $end  = Carbon::parse($member_date);
                    if ($member_date < Carbon::now()->format('Y-m-d')){
                         Mail::to($member->email)->send(new expired($member->id)); 
                    }
            }
    }
    public function joinfree()
    {
        $members    =   DB::table('trial_member')->get();
            foreach ($members as $member) {
                $member_date = $member->created_at;
                $member_email = $member->email;
                $now  = Carbon::parse(Carbon::now());
                $end  = Carbon::parse($member_date);
                    if ($member_date < Carbon::now()->format('Y-m-d')){
                        if ($range_date == 14 || $range_date == 7 || $range_date == 1 ){     
                            Mail::to($member->email)->send(new jofree($member->id)); 
                        }
                    }
            }
    }
    public function testtime()
    {
       dd( date("h:i:sa") );
    }
    
}
