<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mail\PromoMail;
use App\Gym;
use App\GymEmail;
use App\ZonaEmail;
use App\CheckinEmail;
use App\Member;
use App\ListEmail;
use Carbon\Carbon;
use Auth;
use App\Memberharian;
class SendemailController extends Controller
{
    //
    public function mail()
    {
        # code...
        if(\App\Permission::SubMenu('224',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $gyms = ListEmail::all();
        return view('dashboard.promoblast.sendemail')->with('gyms',$gyms);
    }
    
       public function kirim(Request $request){
            $msg = $request->get('description');
            $subject = $request->get('subject');
            foreach($request->get('gyms') as $paket){
                $list = LIstEmail::where('id',$paket)->first();
                $obj = Member::orderBy('members.id','asc');
                
                    if(!empty($list->usia_min)){
                        $minimal = Carbon::now()->addYears(-$list->usia_min);
                        $maximal = Carbon::now()->addYears(-$list->usia_max);
                        
                     $obj->where('date_of_birth','<=',Carbon::now()->addYears(-$list->usia_min))->where('date_of_birth','>=',Carbon::now()->addYears(-$list->usia_max));        
                    }
                    if(!empty($list->bulan)){
                        $obj->where('date_of_birth','>=','01'.$list->bulan.date('Y'))->where('date_of_birth','<=','31'.$list->bulan.date('Y'));
                    }
                    if($list->member_baru_paket != 0){
                        $obj->where('type','new')->where('package_id',$list->member_baru_paket);
                     dd($obj->get());
                    }
                    if($list->member_baru_paket != 0){
                        $obj->where('type','extend')->where('package_id',$list->member_baru_paket);
                     dd($obj->get());
                    }
                    if($list->paket != 0){
                        $obj->where('package_id',$list->member_baru_paket);
                     dd($obj->get());
                    }
                    if(!is_null($list->expire)){
                        if($list->expire == 0){
                            $obj->where('exprired_at','<',date('Y-m-d'));
                        }else{
                            $day = Carbon::now()->addDays($list->expire);
                            $obj->where('exprired_at',$day);
                        }
                    }
                    if($list->member_belum_aktivais == 1){
                        $obj->where('status','pending');
                    }
                    
                foreach($obj->get() as $member){
                     Mail::to($member->email)->send(new PromoMail($msg,$subject,$member->id));     
                    }
                if($list->gym_harian == 1){
                    $harian = Memberharian::get();
                    foreach($harian as $har){
                        Mail::to($har->email)->send(new PromoMail($msg,$subject,$member->id));     
                    }
                }
                if($list->free_tial == 1){
                    $free = trial_member::get();
                    foreach($free as $har){
                        Mail::to($har->email)->send(new PromoMail($msg,$subject,$member->id));     
                    }
                }
                $checkin = CheckinEmail::where('list_email_id',$paket)->get();
                if($checkin != null){
                    foreach($checkin as $check){
                        $member = Member::where('gym_id',$check->attendaces_id)->get();
                        foreach($member as $mem){
                            Mail::to($mem->email)->send(new PromoMail($msg,$subject,$member->id));
                        }
                    }
                }
                $zona = ZonaEmail::where('list_email_id',$paket)->get();
                if($zona != null){
                    foreach($zona as $check){
                        $zone = Gym::where('zona_id',$check->zona_id)->get();
                        foreach($zone as $zon){
                            $member = Member::where('gym_id',$zon->id)->get();
                                foreach($member as $mem){
                                Mail::to($mem->email)->send(new PromoMail($msg,$subject,$member->id));
                            }
                        }
                        
                    }
                }
                $gym = GymEmail::where('list_email_id',$paket)->get();
                if($gym != null){
                    foreach($gym as $check){
                       
                            $member = Member::where('gym_id',$check->gym_id)->get();
                                foreach($member as $mem){
                                Mail::to($mem->email)->send(new PromoMail($msg,$subject,$member->id));
                            }
                        
                        
                    }
                }
                
            }
           
            //Mail::to('adi@example.com')->send(new PromoMail(new member(['msg'=>$request->description])));
            
          // Mail::to('grustf@gmail.com')->send(new PromoMail($request->get('description')));
            $request->session()->flash('alert-success','Promo sudah terkirim');
            return redirect('/u/mail'); 
    }
}
