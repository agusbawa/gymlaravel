<?php
namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Gym;
use App\Member;
use Carbon\Carbon;
use App\PackagePrice;
use App\Zona;
use DB;
use Excel;
use PDF;
use App\MemberHistory;
class MemberReportController extends Controller
{
    public function member (Request $request)
    {
        
        # code...
        $tertentugym = array();
        $tertentuzona = array();
        if($request->get('gyms')){
            $tertentugym = $request->get('gyms');
        }
        if($request->get('zonas')){
            $tertentuzona = $request->get('zonas');
        }
        if($request->get('range')){
           
            $range     =   explode(" - ", $request->get('range'));
        $backdate      =   date("Y-m-d", strtotime($range[0]));
        $currentdate      =   date("Y-m-d", strtotime($range[1]));
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        
        
        }else{
            $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days');
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('-15 days')->toDateTimeString();
        }
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        
        $allmember = Member::get()->count();
        
        $activemember = Member::where('expired_at','>',$currentdate)->get()->count();
        // dd(Member::whereBetween('expired_at',[$backdate,$currentdate])->get(),$currentdate);
    $per_activemember = number_format(($activemember / $allmember) * 100,0,'.','');
        $joinmember = Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
           
            ->get()->count();
    
        $per_joinmember = number_format(($joinmember / $allmember) * 100,0,'.','');
        $memberbaru =  Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
            ->get()->count();
            if($memberbaru && $joinmember){
        $per_memberbaru = number_format(($memberbaru/$joinmember)*100,0,'.','');
            }else{
                 $per_memberbaru = 0;
            }
        $paketsatu = Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
        ->where('members.type','New')
       ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','30')
        ->get()->count();
        if($paketsatu && $memberbaru){
        $per_paketsatu = number_format(($paketsatu / $memberbaru) * 100,0,'.','');
        }else{
            $per_paketsatu= 0;
        }
        $paketdua =Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','90')
        ->get()->count();
        if($paketsatu && $memberbaru){
            $per_paketdua = number_format(($paketdua / $memberbaru) * 100,0,'.','');
        }else{
            $per_paketdua = 0;
        }
        
         $paketiga =Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','180')
        ->get()->count();
        if($paketiga && $memberbaru){
             $per_paketiga = number_format(($paketiga / $memberbaru) * 100,0,'.','');
        }else{
             $per_paketiga = 0;
        }
       
         $paketpat =Member::where('members.expired_at','>',$currentdate)
       ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','365')
        ->get()->count();
        if($paketpat && $memberbaru){
             $per_paketpat = number_format(($paketpat / $memberbaru) * 100,0,'.','');
        }else{
             $per_paketpat =0;
        }
       
        $jumperpanjang =  Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','extends')
            ->get()->count();
            if($jumperpanjang && $allmember){
              $per_jumperpanjang = number_format(($jumperpanjang / $allmember) * 100,0,'.','');
        }else{
               $per_jumperpanjang = 0;
        }
      
       
        $paketperpanjang =Member::where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','extends')
        ->join('package_prices','members.package_id','=','package_prices.id')
      ;
        
        $expired = Member::where('expired_at','<',$currentdate)->get()->count();
        if($expired && $allmember){
              $per_expired = number_format(($expired / $allmember) * 100,0,'.','');
        }else{
               $per_expired = 0;
        }
       
        $will = Member::whereBetween('expired_at',[$backdate,$tofifteen])->get()->count();
        if($will && $allmember){
              $per_will = number_format(($will / $allmember) * 100,0,'.','');
        }else{
               $per_will = 0;
        }
         
        return view('dashboard.report.member.member',compact('gym','zona','tertentugym','tertentuzona'))
        ->with('allmember',$allmember)
        ->with('activemember',$activemember)
        ->with('per_activemember',$per_activemember)
        ->with('joinmember',$joinmember)
        ->with('per_joinmember',$per_joinmember)
        ->with('paketsatu',$paketsatu)
        ->with('per_paketsatu',$per_paketsatu)
        ->with('paketdua',$paketdua)
        ->with('per_paketdua',$per_paketdua)
        ->with('paketiga',$paketiga)
        ->with('per_paketiga',$per_paketiga)
        ->with('paketpat',$paketpat)
        ->with('per_paketpat',$per_paketpat)
 
         ->with('jumperpanjang',$jumperpanjang)
         ->with('per_jumperpanjang',$per_jumperpanjang)
        
        
         ->with('expired',$expired)
         ->with('per_expired',$per_expired)
         ->with('will',$will)
         ->with('per_will',$per_will)
         ->with('memberbaru',$memberbaru)
         ->with('per_memberbaru',$per_memberbaru)
         ->with('paketperpanjang',$paketperpanjang)
         ->with('backdate',$backdate)
         ->with('currentdate',$currentdate)
        ;
    }
    public function searchmember(Request $request)
    {
        $nama_gym = $request->lokasi;
        $tertentugym = array();
        $tertentuzona = array();
        $tertentugymku = array();
            if($request->get('gyms')){
                $tertentugym = $request->get('gyms');
            }
            if($request->get('zonasku')){
                $tertentuzona = $request->get('zonasku');
            }
            if($request->get('gymku')){
                $tertentugymku = $request->get('gymku');
            }
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        // dd($request);
        if($request->get('range')!= null){
            $range                  =   explode(" - ", $request->get('range'));
            
        $backdate      =   date("Y-m-d", strtotime($range[0]));
        $currentdate      =   date("Y-m-d", strtotime($range[1]));
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        
        
        }else{
            $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }
        # code...
        if($request->lokasi == 1||$request->lokasi == 3||$request->lokasi == 5){
            if($request->lokasi == 1){
                $gyms = Gym::orderBy('title','ASC')->get();
            }else if($request->lokasi == 3){
                $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugym)->get();   
            }else if($request->lokasi == 5){
                $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugymku)->get();   
            }
        $allmember = Member::get()->count();
          $activemember = Member::where('expired_at','>',$currentdate)->get()->count();
        
          $joinmember = Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->get()->count();
        $memberbaru = Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
            ->get()->count();
        $paketbaru = Member::where('members.expired_at','>',$currentdate)
        ->where('members.type','New')->whereBetween('members.expired_at',[$currentdate,$tofifteen])
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->whereBetween('members.updated_at',[$backdate,$currentdate])
        ;
         $paketpanjang = Member::where('members.expired_at','>',$currentdate)
        ->where('members.type','extends')->whereBetween('members.expired_at',[$currentdate,$tofifteen])
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->whereBetween('members.updated_at',[$backdate,$currentdate])
        ;
        $paketsatu = Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
        ->where('members.type','New')
       ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','30')
        ->get()->count();
          if($paketsatu && $memberbaru){
                $per_paketsatu = number_format(($paketsatu / $memberbaru) * 100,0,'.','');
        }else{
               $per_paketsatu = 0;  
        }
        
        $paketdua =Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','90')
        ->get()->count();
        if($paketdua && $memberbaru){
                $per_paketdua = number_format(($paketdua / $memberbaru) * 100,0,'.','');
        }else{
                $per_paketdua =0;
        }
       
         $paketiga =Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','180')
        ->get()->count();
        if($paketiga && $memberbaru){
               $per_paketiga = number_format(($paketiga / $memberbaru) * 100,0,'.','');
        }else{
                $per_paketiga = 0;
        }
       
         $paketpat =Member::where('members.expired_at','>',$currentdate)
       ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','365')
        ->get()->count();
        if($paketpat && $memberbaru){
              $per_paketpat = number_format(($paketpat / $memberbaru) * 100,0,'.','');
        }else{
               $per_paketpat = 0;
        }
        
        
        $jumperpanjang = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','extends')
             ->whereBetween('member_histories.extends',[$backdate,$currentdate])
            ->get()->count();

         $paketpanjangsatu =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $perpanjangdua =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

        $perpanjangtiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

        $perpanjangpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();
        $memberbaru = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','New')
            ->where('member_histories.new_register','<',$currentdate)
            ->Where('member_histories.new_register','>',$backdate)
            ->get()->count();
            if($memberbaru && $allmember){
              $per_memberbaru = number_format(($memberbaru/$joinmember)*100,0,'.','');
        }else{
               $per_memberbaru = 0;
        }
        
        $expired = Member::where('expired_at','<',$currentdate)->get()->count();
        $paketperpanjang =Member::where('members.expired_at','>',$currentdate)
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $will = Member::whereBetween('expired_at',[$currentdate,$tofifteen])->get()->count();

        if($activemember && $allmember){
              $per_activemember = number_format(($activemember / $allmember) * 100,0,'.','');
        }else{
               $per_activemember = 0;
        }
        if($joinmember && $allmember){
             $per_joinmember = number_format(($joinmember / $allmember) * 100,0,'.','');
        }else{
               $per_joinmember = 0;
        }
        
        if($memberbaru && $joinmember){
              $per_memberbaru = number_format(($memberbaru/$joinmember)*100,0,'.','');
        }else{
               $per_memberbaru = 0;
        }

        if($jumperpanjang && $joinmember){
              $per_jumperpanjang = number_format(($jumperpanjang / $joinmember) * 100,0,'.','');
        }else{
              $per_jumperpanjang = 0;
        }
       
        if($expired && $allmember){
               $per_expired = number_format(($expired / $allmember) * 100,0,'.','');
        }else{
               $per_expired = 0;
        }
       if($will && $allmember){
               $per_will = number_format(($will / $allmember) * 100,0,'.','');
        }else{
               $per_will = 0;
        }
        
        return view('dashboard.report.member.searchmember',compact('nama_gym','gym','zona','tertentugym','tertentuzona','tertentugymku'))
        ->with('allmember',$allmember)
        ->with('activemember',$activemember)
        ->with('joinmember',$joinmember)
        ->with('paketsatu',$paketsatu)
        ->with('paketdua',$paketdua)
        ->with('paketiga',$paketiga)
        ->with('paketpat',$paketpat)
        ->with('perpanjangsatu',$paketpanjangsatu)
         ->with('jumperpanjang',$jumperpanjang)
         ->with('perpanjangdua',$perpanjangdua)
         ->with('perpanjangtiga',$perpanjangtiga)
         ->with('perpanjangpat',$perpanjangpat)
         ->with('expired',$expired)
         ->with('will',$will)
         ->with('gyms',$gyms)
         ->with('currentdate',$currentdate)
         ->with('backdate',$backdate)
         ->with('tofifteen',$tofifteen)
         ->with('per_activemember',$per_activemember)
         ->with('per_joinmember',$per_joinmember)
         ->with('per_memberbaru',$per_memberbaru)
         ->with('per_jumperpanjang',$per_jumperpanjang)
         ->with('per_expired',$per_expired)
         ->with('per_will',$per_will)
         ->with('per_paketsatu',$per_paketsatu)
         ->with('per_paketdua',$per_paketdua)
         ->with('per_paketiga',$per_paketiga)
         ->with('per_paketpat',$per_paketpat)
         ->with('memberbaru',$memberbaru)
         ->with('paketbaru',$paketbaru)
         ->with('paketpanjang',$paketpanjang)
         ->with('paketperpanjang',$paketperpanjang)
        ;
        }
        else if ($request->lokasi == 2||$request->lokasi == 4){
            if($request->lokasi == 2){
                $zonas = Zona::orderBy('title','ASC')->get();
            }else{
                $zonas = Zona::orderBy('title','ASC')->whereIn('id',$tertentuzona)->get();
            }
            $allmember = Member::get()->count();
        $activemember = Member::where('expired_at','>',$currentdate)->get()->count();
        
          $joinmember = Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->get()->count();
        $memberbaru = Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
            ->get()->count();
        $paketbaru = Member::where('members.expired_at','>',$currentdate)
        ->where('members.type','New')->whereBetween('members.expired_at',[$currentdate,$tofifteen])
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->whereBetween('members.updated_at',[$backdate,$currentdate])
        ;
         $paketpanjang = Member::where('members.expired_at','>',$currentdate)
        ->where('members.type','extends')->whereBetween('members.expired_at',[$currentdate,$tofifteen])
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->whereBetween('members.updated_at',[$backdate,$currentdate])
        ;
        $paketsatu = Member::where('members.expired_at','<',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
        ->where('members.type','New')
       ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','30')
        ->get()->count();
          if($paketsatu && $memberbaru){
                $per_paketsatu = number_format(($paketsatu / $memberbaru) * 100,0,'.','');
        }else{
               $per_paketsatu = 0;  
        }
        
        $paketdua =Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','90')
        ->get()->count();
        if($paketdua && $memberbaru){
                $per_paketdua = number_format(($paketdua / $memberbaru) * 100,0,'.','');
        }else{
                $per_paketdua =0;
        }
       
         $paketiga =Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','180')
        ->get()->count();
        if($paketiga && $memberbaru){
               $per_paketiga = number_format(($paketiga / $memberbaru) * 100,0,'.','');
        }else{
                $per_paketiga = 0;
        }
       
         $paketpat =Member::where('members.expired_at','>',$currentdate)
       ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
        ->join('package_prices','members.package_id','=','package_prices.id')
        
        ->where('package_prices.day','=','365')
        ->get()->count();
        if($paketpat && $memberbaru){
              $per_paketpat = number_format(($paketpat / $memberbaru) * 100,0,'.','');
        }else{
               $per_paketpat = 0;
        }
        
        
        $jumperpanjang = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','extends')
             ->whereBetween('member_histories.extends',[$backdate,$currentdate])
            ->get()->count();

         $paketpanjangsatu =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $perpanjangdua =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

        $perpanjangtiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

        $perpanjangpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();
        $memberbaru = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','New')
            ->where('member_histories.new_register','<',$currentdate)
            ->Where('member_histories.new_register','>',$backdate)
            ->get()->count();
             if($activemember && $allmember){
              $per_activemember = number_format(($activemember / $allmember) * 100,0,'.','');
        }else{
               $per_activemember = 0;
        }
       
        $expired = Member::where('expired_at','<',$currentdate)->get()->count();
        $paketperpanjang =Member::where('members.expired_at','>',$currentdate)
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $will = Member::whereBetween('expired_at',[$currentdate,$tofifteen])->get()->count();

        if($activemember && $allmember){
              $per_activemember = number_format(($activemember / $allmember) * 100,0,'.','');
        }else{
               $per_activemember = 0;
        }
        if($joinmember && $allmember){
             $per_joinmember = number_format(($joinmember / $allmember) * 100,0,'.','');
        }else{
               $per_joinmember = 0;
        }
        
        if($memberbaru && $joinmember){
              $per_memberbaru = number_format(($memberbaru/$joinmember)*100,0,'.','');
        }else{
               $per_memberbaru = 0;
        }

        if($jumperpanjang && $joinmember){
              $per_jumperpanjang = number_format(($jumperpanjang / $joinmember) * 100,0,'.','');
        }else{
              $per_jumperpanjang = 0;
        }
       
        if($expired && $allmember){
               $per_expired = number_format(($expired / $allmember) * 100,0,'.','');
        }else{
               $per_expired = 0;
        }
       if($will && $allmember){
               $per_will = number_format(($will / $allmember) * 100,0,'.','');
        }else{
               $per_will = 0;
        }
          $baru = Zona::orderBy('zonas.created_at','asc')
                                    ->join('gyms','gyms.zona_id','=','zonas.id')
                                    ->join('members','members.gym_id','=','gyms.id')
                                    ->join('member_histories','member_histories.member_id','=','members.id')
                                  //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                   ->where('members.type','New')
                                    ->join('package_prices','member_histories.package_price_id','=','package_prices.id');
                                   
        $perpanjang = Zona::orderBy('zonas.created_at','asc')
                                    ->join('gyms','gyms.zona_id','=','zonas.id')
                                    ->join('members','members.gym_id','=','gyms.id')
                                    ->join('member_histories','member_histories.member_id','=','members.id')
                                  //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                    ->where('members.type','extends')
                                    ->join('package_prices','member_histories.package_price_id','=','package_prices.id');
                                    
            return view('dashboard.report.member.zonamember',compact('nama_gym','gym','zona','tertentugym','tertentuzona','tertentugymku'))->with('zonas',$zonas)
            ->with('allmember',$allmember)
        ->with('activemember',$activemember)
        ->with('per_activemember',$per_activemember)
        ->with('joinmember',$joinmember)
        ->with('per_joinmember',$per_joinmember)
        ->with('paketsatu',$paketsatu)
        ->with('per_paketsatu',$per_paketsatu)
        ->with('paketdua',$paketdua)
        ->with('per_paketdua',$per_paketdua)
        ->with('paketiga',$paketiga)
        ->with('per_paketiga',$per_paketiga)
        ->with('paketpat',$paketpat)
        ->with('per_paketpat',$per_paketpat)
        ->with('perpanjangsatu',$paketpanjangsatu)
      //  ->with('per_panjangsatu',$per_paketpanjangsatu)
         ->with('jumperpanjang',$jumperpanjang)
         ->with('per_jumperpanjang',$per_jumperpanjang)
         //->with('perpanjangdua',$perpanjangdua)
         //->with('per_perpanjangdua',$per_perpanjangdua)
         //->with('perpanjangtiga',$perpanjangtiga)
         //->with('per_perpanjangtiga',$per_perpanjangtiga)
         //->with('perpanjangpat',$perpanjangpat)
         //->with('per_perpanjangpat',$per_perpanjangpat)
         ->with('expired',$expired)
         ->with('per_expired',$per_expired)
         ->with('will',$will)
         ->with('per_will',$per_will)
         ->with('memberbaru',$memberbaru)
         ->with('per_memberbaru',$per_memberbaru)
         ->with('paketperpanjang',$paketperpanjang)
         ->with('backdate',$backdate)
         ->with('currentdate',$currentdate)
         ->with('tofifteen',$tofifteen)
         ->with('baru',$baru)
         ->with('perpanjang',$perpanjang)
        ;
        }
    else{
        if($request->get('range')){
            $range = $request->get('range');
           
        }else{
            $range = null;
        }
        return redirect('/u/report/member')->withInput(['range'=>$range]);
    }
    }

    public function link_zonamember(Request $request, $id)
    {
        $nama_gym = $request->lokasi;
        $tertentugym = array();
        $tertentuzona = array();
        $tertentugymku = array();
            if($request->get('gyms')){
                $tertentugym = $request->get('gyms');
            }
            if($request->get('zonasku')){
                $tertentuzona = $request->get('zonasku');
            }
            if($request->get('gymku')){
                $tertentugymku = $request->get('gymku');
            }
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        // dd($request);
        if($request->get('range')!= null){
            $range                  =   explode(" - ", $request->get('range'));
        $backdate      =   date("Y-m-d", strtotime($range[0]));
        $currentdate      =   date("Y-m-d", strtotime($range[1]));
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }else{
            $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }
        # code...
        
        $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();   

        $allmember = Member::get()->count();
        $activemember = Member::where('expired_at','>',$currentdate)->get()->count();
        $joinmember = Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->get()->count();
        $paketsatu = Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $paketdua =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

         $paketiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

         $paketpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();
        
        $jumperpanjang = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','extends')
             ->whereBetween('member_histories.extends',[$backdate,$currentdate])
            ->get()->count();

         $paketpanjangsatu =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $perpanjangdua =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

        $perpanjangtiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

        $perpanjangpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();

        $expired = Member::where('expired_at','<',$currentdate)->get()->count();
        $will = Member::whereBetween('expired_at',[$currentdate,$tofifteen])->get()->count();
        return view('dashboard.report.member.link_zonamember',compact('nama_gym','gym','zona','tertentugym','tertentuzona','id'))
        ->with('allmember',$allmember)
        ->with('activemember',$activemember)
        ->with('joinmember',$joinmember)
        ->with('paketsatu',$paketsatu)
        ->with('paketdua',$paketdua)
        ->with('paketiga',$paketiga)
        ->with('paketpat',$paketpat)
        ->with('perpanjangsatu',$paketpanjangsatu)
         ->with('jumperpanjang',$jumperpanjang)
         ->with('perpanjangdua',$perpanjangdua)
         ->with('perpanjangtiga',$perpanjangtiga)
         ->with('perpanjangpat',$perpanjangpat)
         ->with('expired',$expired)
         ->with('will',$will)
         ->with('gyms',$gyms)
         ->with('currentdate',$currentdate)
         ->with('backdate',$backdate)
         ->with('tofifteen',$tofifteen)
        ;
    }

    public function exportExcel()
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $allmember = Member::get()->count();
        
        $activemember = Member::where('expired_at','>',$currentdate)->get()->count();
        $per_activemember = number_format(($activemember / $allmember) * 100,2,'.','');
        $joinmember = Member::OrderBy('members.id','DESC')
            ->whereBetween('extended_at',[$backdate,$currentdate])
            ->get()->count();

        $per_joinmember = number_format(($joinmember / $allmember) * 100,2,'.','');

        $paket = Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->get()->count();

        $paketsatu = Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $paketdua =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

         $paketiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

         $paketpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();
       
        $per_paketsatu = number_format(($paketsatu / $allmember) * 100,2,'.','');
       
        $per_paketdua = number_format(($paketdua / $allmember) * 100,2,'.','');
        
        $per_paketiga = number_format(($paketiga / $allmember) * 100,2,'.','');
       
        $per_paketpat = number_format(($paketpat / $allmember) * 100,2,'.','');

        $jumperpanjang = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','extends')
             ->whereBetween('member_histories.extends',[$backdate,$currentdate])
            ->get()->count();

        $panjangsatu =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $panjangdua =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

        $panjangtiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

        $panjangpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();

        $per_jumperpanjang = number_format(($jumperpanjang / $allmember) * 100,2,'.','');
        
        $per_perpanjangsatu = number_format(($panjangsatu / $allmember) * 100,2,'.','');
       
        $per_perpanjangdua = number_format(($panjangdua / $allmember) * 100,2,'.','');
       
        $per_perpanjangtiga = number_format(($panjangtiga / $allmember) * 100,2,'.','');
        
        $per_perpanjangpat = number_format(($panjangpat / $allmember) * 100,2,'.','');

        $expired = Member::where('expired_at','<=',$currentdate)->get()->count();
        $per_expired = number_format(($expired / $allmember) * 100,2,'.','');
        $will = Member::whereBetween('expired_at',[$currentdate,$tofifteen])->get()->count();
        $per_will = number_format(($will / $allmember) * 100,2,'.','');
        return Excel::create('Report Member All', function($excel) use ($allmember,$activemember,$jumperpanjang,$joinmember,$expired,$will,$per_activemember,$per_jumperpanjang,$per_joinmember,$per_paketsatu,$per_paketdua,$per_paketiga,$per_paketpat,$per_perpanjangsatu,$per_perpanjangdua,$per_perpanjangtiga,$per_perpanjangpat,$per_expired,$per_will,$paketsatu,$paketdua,$paketiga,$paketpat,$panjangsatu,$panjangdua,$panjangtiga,$panjangpat,$paket){
            $excel->sheet('New sheet', function($sheet) use ($allmember,$activemember,$jumperpanjang,$joinmember,$expired,$will,$per_activemember,$per_jumperpanjang,$per_joinmember,$per_paketsatu,$per_paketdua,$per_paketiga,$per_paketpat,$per_perpanjangsatu,$per_perpanjangdua,$per_perpanjangtiga,$per_perpanjangpat,$per_expired,$per_will,$paketsatu,$paketdua,$paketiga,$paketpat,$panjangsatu,$panjangdua,$panjangtiga,$panjangpat,$paket){
                $sheet->loadView('dashboard.report.member.member_excel')->with('allmember',$allmember)
                                                                        ->with('activemember',$activemember)
                                                                        ->with('per_activemember',$per_activemember)
                                                                        ->with('joinmember',$joinmember)
                                                                        ->with('per_joinmember',$per_joinmember)
                                                                        ->with('per_paketsatu',$per_paketsatu)
                                                                        ->with('per_paketdua',$per_paketdua)
                                                                        ->with('per_paketiga',$per_paketiga)
                                                                        ->with('per_paketpat',$per_paketpat)
                                                                         ->with('jumperpanjang',$jumperpanjang)
                                                                         ->with('per_jumperpanjang',$per_jumperpanjang)
                                                                         ->with('per_perpanjangsatu',$per_perpanjangsatu)
                                                                         ->with('per_perpanjangdua',$per_perpanjangdua)
                                                                         ->with('per_perpanjangtiga',$per_perpanjangtiga)
                                                                         ->with('per_perpanjangpat',$per_perpanjangpat)
                                                                         ->with('expired',$expired)
                                                                         ->with('per_expired',$per_expired)
                                                                         ->with('will',$will)
                                                                         ->with('per_will',$per_will)
                                                                         ->with('paket',$paket)
                                                                         ->with('paketsatu',$paketsatu)
                                                                         ->with('paketdua',$paketdua)
                                                                         ->with('paketiga',$paketiga)
                                                                         ->with('paketpat',$paketpat)
                                                                         ->with('panjangsatu',$panjangsatu)
                                                                         ->with('panjangdua',$panjangdua)
                                                                         ->with('panjangtiga',$panjangtiga)
                                                                         ->with('panjangpat',$panjangpat)
                                                                         ;
            });
        })->download('xls');
    }

    public function exportPDF()
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();

        $allmember = Member::get()->count();
        $activemember = Member::where('status','ACTIVE')->get()->count();
        $per_activemember = number_format(($activemember / $allmember) * 100,2,'.','');
        $joinmember = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','extends')
            ->where('member_histories.new_register','<',$currentdate)
            ->orWhere('member_histories.new_register','>',$backdate)
            ->get()->count();

        $paket = Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->get()->count();

        $paketsatu = Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $paketdua = Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

         $paketiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

         $paketpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();


        $per_joinmember = number_format(($joinmember / $allmember) * 100,2,'.','');
       
        $per_paketsatu = number_format(($paketsatu / $allmember) * 100,2,'.','');
       
        $per_paketdua = number_format(($paketdua / $allmember) * 100,2,'.','');
        
        $per_paketiga = number_format(($paketiga / $allmember) * 100,2,'.','');
       
        $per_paketpat = number_format(($paketpat / $allmember) * 100,2,'.','');

        $jumperpanjang = Member::OrderBy('members.id','DESC')
            ->join('member_histories','member_histories.member_id','=','members.id')
            ->where('members.type','extends')
             ->whereBetween('member_histories.extends',[$backdate,$currentdate])
            ->get()->count();

        $panjangsatu =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count();

        $panjangdua =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count();

        $panjangtiga =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count();

        $panjangpat =Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count();

        $per_jumperpanjang = number_format(($jumperpanjang / $allmember) * 100,2,'.','');
        
        $per_perpanjangsatu = number_format(($panjangsatu / $allmember) * 100,2,'.','');
       
        $per_perpanjangdua = number_format(($panjangdua / $allmember) * 100,2,'.','');
       
        $per_perpanjangtiga = number_format(($panjangtiga / $allmember) * 100,2,'.','');
        
        $per_perpanjangpat = number_format(($panjangpat / $allmember) * 100,2,'.','');

        $expired = Member::where('expired_at','<',$currentdate)->get()->count();
        $per_expired = number_format(($expired / $allmember) * 100,2,'.','');
        $will = Member::whereBetween('expired_at',[$currentdate,$tofifteen])->get()->count();
        $per_will = number_format(($will / $allmember) * 100,2,'.','');

        $pdf = PDF::loadView('dashboard.report.member.member_pdf',compact('allmember','activemember','jumperpanjang','joinmember','expired','will','per_activemember','per_jumperpanjang','per_joinmember','paket','per_paketsatu','per_paketdua','per_paketiga','per_paketpat','per_perpanjangsatu','per_perpanjangdua','per_perpanjangtiga','per_perpanjangpat','per_expired','per_will','paketsatu','paketdua','paketiga','paketpat','panjangsatu','panjangdua','panjangtiga','panjangpat'));
         $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function exportExcel_1(Request $request)
    {
        $id = $request->get('id');
        $tertentugym = array();
        $tertentuzona = array();
        $tertentugymku = array();
        $range = $request->get('range');
        if($request->get('range')!= null){
            $range                  =   explode(" - ", $request->get('range'));
            $backdate      =   date("Y-m-d", strtotime($range[0]));
            $currentdate      =   date("Y-m-d", strtotime($range[1]));
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }else{
            $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }
        if($request->get('gyms')){
            $tertentugym = $request->get('gyms');
        }
        if($request->get('zonasku')){
            $tertentuzona = $request->get('zonasku');
        }
        if($request->get('gymku')){
            $tertentugymku = $request->get('gymku');
        }

        if($id==null)
        {
            if($request->lokasi == 1){
                $gyms = Gym::orderBy('title','ASC')->get();
            }else if($request->lokasi == 3){
                $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugym)->get();   
            }else if($request->lokasi == 5){
                $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugymku)->get();   
            }else if($request->lokasi == 2){
                $zonas = Zona::orderBy('title','ASC')->get();
            }else if($request->lokasi == 4){
                $zonas = Zona::orderBy('title','ASC')->whereIn('id',$tertentuzona)->get();
            }
        }else{
            $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();  
        }
        if($request->lokasi == 1||$request->lokasi == 3||$request->lokasi == 5||$id!=null)
        {
            return Excel::create('Report Member All', function($excel) use ($gyms,$backdate,$currentdate,$tofifteen){
                $excel->sheet('New sheet', function($sheet) use ($gyms,$backdate,$currentdate,$tofifteen){
                    $sheet->loadView('dashboard.report.member.search_excel')->with('gyms',$gyms)
                                                                            ->with('backdate',$backdate)
                                                                            ->with('currentdate',$currentdate)
                                                                            ->with('tofifteen',$tofifteen);
                });
            })->download('xls');
        }else{
            return Excel::create('Report Member All', function($excel) use ($zonas,$backdate,$currentdate,$tofifteen){
                $excel->sheet('New sheet', function($sheet) use ($zonas,$backdate,$currentdate,$tofifteen){
                    $sheet->loadView('dashboard.report.member.zona_excel')->with('zonas',$zonas)
                                                                            ->with('backdate',$backdate)
                                                                            ->with('currentdate',$currentdate)
                                                                            ->with('tofifteen',$tofifteen);
                });
            })->download('xls');
        }
    }

    public function exportPDF_1(Request $request)
    {
        $id = $request->get('id');
        $tertentugym = array();
        $tertentuzona = array();
        $tertentugymku = array();
        if($request->get('range')!= null){
            $range                  =   explode(" - ", $request->get('range'));
            $backdate      =   date("Y-m-d", strtotime($range[0]));
            $currentdate      =   date("Y-m-d", strtotime($range[1]));
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }else{
            $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }
        if($request->get('gyms')){
            $tertentugym = $request->get('gyms');
        }
        if($request->get('zonasku')){
            $tertentuzona = $request->get('zonasku');
        }
        if($request->get('gymku')){
            $tertentugymku = $request->get('gymku');
        }

        if($id==null)
        {
            if($request->lokasi == 1){
                $gyms = Gym::orderBy('title','ASC')->get();
            }else if($request->lokasi == 3){
                $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugym)->get();   
            }else if($request->lokasi == 5){
                $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugymku)->get();   
            }else if($request->lokasi == 2){
                $zonas = Zona::orderBy('title','ASC')->get();
            }else if($request->lokasi == 4){
                $zonas = Zona::orderBy('title','ASC')->whereIn('id',$tertentuzona)->get();
            }
        }else{
            $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();  
        }

        if($request->lokasi == 1||$request->lokasi == 3||$request->lokasi == 5||$id!=null)
        {
            $pdf = PDF::loadView('dashboard.report.member.search_pdf',compact('gyms','backdate','currentdate','tofifteen'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('Report Member.pdf');
        }else{
            $pdf = PDF::loadView('dashboard.report.member.zona_pdf',compact('zonas','backdate','currentdate','tofifteen'));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('Report Member.pdf');
        }
    }
}