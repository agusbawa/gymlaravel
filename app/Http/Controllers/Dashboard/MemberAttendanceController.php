<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Gym;
use App\Member;
use App\CardMember;
use App\Attendance;
use Auth;
use DB;
use Carbon\Carbon;
class MemberAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         
        if(\App\Permission::SubMenu('18',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        if(!empty($request->get('member')) && !empty($request->get('gym'))){
             \Validator::make($request->all(),[
            'gym'              =>'required',
            'member'           =>'required',
            ])->setAttributeNames([
            'gym'              =>'Gym',
            'member'             =>'ID Member',
            ])->validate();
            $promo = Member::where('card',$request->get('member'))->orWhere('slug',$request->get('member'))->first();
             if ($promo==null) {
                $request->session()->flash('alert-error', 'Kemungkinan membercard belum tertaut');
                return redirect()->back()->withInput();
            }
            $membercard  = Member::where('card',$request->get('member'))->orWhere('slug',$request->get('member'))->first();
            $member = Member::where('card',$request->get('member'))->orWhere('slug',$request->get('member'))->first();
            $att = Attendance::orderBy('created_at','desc')->where('member_id',$membercard->id)->first();
          
            if($att == null){
                $checkin = 'checkin';
            }else{
                 if($att->check_in != $att->check_out ){
                    $checkin = 'checkin';
                }else{
                if(date('Y-m-d',strtotime($att->created_at))==date('Y-m-d'))
                {
                        if($att->check_in == $att->check_out){
                            $checkin = $att;  
                        }else{
                            $checkin = 'checkin';
                        }
                
              }else{
              $checkin = 'checkin';
              }
            }
            }
        }else{
        $member = null;
        $checkin = null;
        $membercard = null; 
        }
         $gyms       =   Gym::get();
         
        return view('dashboard.member.attendance')->with('gyms',$gyms)->with('member',$member)->with('membercard',$membercard)->with('checkin',$checkin);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            'gym'              =>'required',
            'member'           =>'required',
        ])->setAttributeNames([
            'gym'              =>'Gym',
            'member'             =>'ID Member',
        ])->validate();

      
        $promo = Member::where('card',$request->get('member'))->orWhere('slug',$request->get('member'))->first();
          
        if ($promo==null) {
            $request->session()->flash('alert-error', 'Kemungkinan membercard belum tertaut');
            return redirect()->back()->withInput();
        }else{
           $member = Member::find($promo->id);
            if($member->expired_at <= Carbon::now())
            {
                $request->session()->flash('alert-error', 'Member ini sudah dalam masa expired');
                return redirect()->back()->withInput();
             
            }else{
            
            $timestamp 			=	\Carbon\Carbon::now();
               $atedances = Attendance::orderBy('id','desc')->whereDate('created_at','=' , date("Y-m-d"))->where('member_id',$member->id)->first();
               if($atedances != null){
               if($atedances->check_in == $atedances->check_out){
                   if($atedances->gym_id != $request->get('gym')){
                        $request->session()->flash('alert-error', 'Member tidak checkin di gym ini');
                        return redirect('/u/members/attendances');
                   }
                  $result     =   $member->processAttendance($request->get('gym'));
                  $request->session()->flash('alert-success', $result.' Berhasil!');
                    return redirect('/u/members/attendances');
               }
               }else{
                   $result     =   $member->processAttendance($request->get('gym'));
                  $request->session()->flash('alert-success', $result.' Berhasil!');
                    return redirect('/u/members/attendances');
               }
                $result     =   $member->processAttendance($request->get('gym'));
                  $request->session()->flash('alert-success', $result.' Berhasil!');
                    return redirect('/u/members/attendances');
            }
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload()
    {
        return view('dashboard.member.attendance.upload');
    }

    /**
     * Upload file CSV
     * File Format
     * OLD_MEMBER_ID, GYM_ID, CHECKIN-DATETIME,     
     */
    public function postUpload(Request $request)
    {
        if(\App\Permission::SubMenu('23',Auth::user()->role_id) == 0){
            return redirect()->back();
      } 
        $kosong = 0;
        $number = 0;
        $results=\Excel::load($request->file('file')->path(), function($reader) {})->get();
                foreach($results->toArray() as $row)
            {
                 if(count($row)!=4){
                
                   $kosong++;
                   continue;
                   
              }
                if($row[0] == null || $row[1] == null || $row[2] == null || $row[3]==null){
                    ++$kosong;
                    continue;
                }else{
                    $checkgym = Gym::find($row[1]);
                    if(is_null($checkgym)){
                        $kosong++;
                    }else
                    {
                        $member                     =   Member::where('slug','=',$row[0])->orWhere('card',$row[0])->first();
                        if (is_null($member)) {
                            continue;
                        }

                        $member->processAttendance($row[1], $row[2]);
                        $member->processAttendance($row[1], $row[3]);

                        ++$number;
                    }
                    }
            }
        

        $request->session()->flash('alert-success', $number.' Berhasil di import');
        return redirect('/u/members');
    }
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
}
