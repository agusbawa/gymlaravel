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
use App\Transaction;
use DB;
use PDF;
use Excel;
class promoController extends Controller
{
    public function member(Request $request)
    {
        # code...
        $nama_gym = "";
        $tertentugym = array();
        $tertentuzona = array();
        if($request->get('gyms')){
            $tertentugym = $request->get('gyms');
        }
        if($request->get('zonas')){
            $tertentuzona = $request->get('zonas');
        }
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $members = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
        $nonpromos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.promo_id','=','0')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
                
        $promos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->get();
        $member_baru = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','!=',null)
                        ->get();
        $member_panjang = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','=',null)
                        ->get();
        
        
        $totalmembers = 0;
        $totalnonpromos = 0;
        $totalpromos = 0;
        $totalmemberbaru = 0;
        $totalmemberpanjang = 0;
        foreach ($members as $member) {
            # code...
            $totalmembers = $totalmembers + $member->total;
        }
        foreach ($nonpromos as $nonpromo) {
            # code...
            $totalnonpromos = $totalnonpromos + $nonpromo->total;
            
        }
        
         foreach ($promos as $promo) {
            # code...
            $totalpromos = $totalpromos + $promo->total;
            
        }
        foreach ($member_baru as $member) {
            # code...
            $totalmemberbaru = $totalmemberbaru + $member->total;
            
        }
        foreach ($member_panjang as $member) {
            # code...
            $totalmemberpanjang = $totalmemberpanjang + $member->total;
            
        }
    
        return view('dashboard.report.promo.index',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('totalmembers',$totalmembers)
        ->with('totalnonpromos',$totalnonpromos)
        ->with('totalpromos',$totalpromos)
        ->with('totalmemberbaru',$totalmemberbaru)
        ->with('totalmemberpanjang',$totalmemberpanjang)
        ;
    }
    public function searchmember(Request $request)
    {
        $nama_gym = $request->lokasi;
        if($nama_gym==0)
        {
            # code...
        $nama_gym = "";
        $tertentugym = array();
        $tertentuzona = array();
        if($request->get('gyms')){
            $tertentugym = $request->get('gyms');
        }
        if($request->get('zonas')){
            $tertentuzona = $request->get('zonas');
        }
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $members = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
        $nonpromos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.promo_id','=','0')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
                
        $promos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->get();
        $member_baru = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','!=',null)
                        ->get();
        $member_panjang = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','=',null)
                        ->get();
        
        
        $totalmembers = 0;
        $totalnonpromos = 0;
        $totalpromos = 0;
        $totalmemberbaru = 0;
        $totalmemberpanjang = 0;
        foreach ($members as $member) {
            # code...
            $totalmembers = $totalmembers + $member->total;
        }
        foreach ($nonpromos as $nonpromo) {
            # code...
            $totalnonpromos = $totalnonpromos + $nonpromo->total;
            
        }
        
         foreach ($promos as $promo) {
            # code...
            $totalpromo = $totalpromo + $promo->total;
            
        }
        foreach ($member_baru as $member) {
            # code...
            $totalmemberbaru = $totalmemberbaru + $member->total;
            
        }
        foreach ($member_panjang as $member) {
            # code...
            $totalmemberpanjang = $totalmemberpanjang + $member->total;
            
        }
    
        return view('dashboard.report.promo.index',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('totalmembers',$totalmembers)
        ->with('totalnonpromos',$totalnonpromos)
        ->with('totalpromos',$totalpromos)
        ->with('totalmemberbaru',$totalmemberbaru)
        ->with('totalmemberpanjang',$totalmemberpanjang)
        ;
        }else{
            # code...
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
            $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            $members = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
        $nonpromos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.promo_id','=','0')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
                
        $promos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->get();
        $member_baru = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','!=',null)
                        ->get();
        $member_panjang = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','=',null)
                        ->get();
        
        
        $totalmembers = 0;
        $totalnonpromos = 0;
        $totalpromos = 0;
        $totalmemberbaru = 0;
        $totalmemberpanjang = 0;
        foreach ($members as $member) {
            # code...
            $totalmembers = $totalmembers + $member->total;
        }
        foreach ($nonpromos as $nonpromo) {
            # code...
            $totalnonpromos = $totalnonpromos + $nonpromo->total;
            
        }
        
         foreach ($promos as $promo) {
            # code...
            $totalpromo = $totalpromo + $promo->total;
            
        }
        foreach ($member_baru as $member) {
            # code...
            $totalmemberbaru = $totalmemberbaru + $member->total;
            
        }
        foreach ($member_panjang as $member) {
            # code...
            $totalmemberpanjang = $totalmemberpanjang + $member->total;
            
        }
            
                if($request->lokasi == 1){
                    $gyms = Gym::orderBy('title','ASC')->get();
                    return view('dashboard.report.promo.searchmember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
             ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('totalmembers',$totalmembers)
        ->with('totalnonpromos',$totalnonpromos)
        ->with('totalpromos',$totalpromos)
        ->with('totalmemberbaru',$totalmemberbaru)
        ->with('totalmemberpanjang',$totalmemberpanjang)
            ;
                }else if($request->lokasi == 3){
                    $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugym)->get();  
                    return view('dashboard.report.promo.searchmember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ; 
                }else if($request->lokasi == 5){
                    $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugymku)->get();  
                    return view('dashboard.report.promo.searchmember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ; 
                }else if($request->lokasi == 2){
                    $zonas = Zona::orderBy('title','ASC')->get();
                    return view('dashboard.report.promo.zonamember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ;
                }else if($request->lokasi == 4){
                    $zonas = Zona::orderBy('title','ASC')->whereIn('id',$tertentuzona)->get();
                    return view('dashboard.report.promo.zonamember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ;
                }   
        }
    }

    public function link_zonapromo(Request $request, $id)
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
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        
                $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();
                return view('dashboard.report.promo.link_zonapromo',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('gym',$gym)
        ->with('zona',$zona)
        
        ;
    }

    public function exportExcel(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $members = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
        $nonpromos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.promo_id','=','0')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
                
        $promos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->get();
        $member_baru = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','!=',null)
                        ->get();
        $member_panjang = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','=',null)
                        ->get();
        
        
        $totalmembers = 0;
        $totalnonpromos = 0;
        $totalpromos = 0;
        $totalmemberbaru = 0;
        $totalmemberpanjang = 0;
        foreach ($members as $member) {
            # code...
            $totalmembers = $totalmembers + $member->total;
        }
        foreach ($nonpromos as $nonpromo) {
            # code...
            $totalnonpromos = $totalnonpromos + $nonpromo->total;
            
        }
        
         foreach ($promos as $promo) {
            # code...
            $totalpromos = $totalpromos + $promo->total;
            
        }
        foreach ($member_baru as $member) {
            # code...
            $totalmemberbaru = $totalmemberbaru + $member->total;
            
        }
        foreach ($member_panjang as $member) {
            # code...
            $totalmemberpanjang = $totalmemberpanjang + $member->total;
            
        }
        return Excel::create('Report Member All', function($excel) use ($totalmembers,$totalnonpromos,$totalpromos,$totalmemberbaru,$totalmemberpanjang){
            $excel->sheet('New sheet', function($sheet) use ($totalmembers,$totalnonpromos,$totalpromos,$totalmemberbaru,$totalmemberpanjang){
                $sheet->loadView('dashboard.report.promo.member_excel')->with('totalmembers',$totalmembers)
                                                                            ->with('totalnonpromos',$totalnonpromos)
                                                                            ->with('totalpromos',$totalpromos)
                                                                            ->with('totalmemberbaru',$totalmemberbaru)
                                                                            ->with('totalmemberpanjang',$totalmemberpanjang);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $members = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
        $nonpromos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.promo_id','=','0')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->get();
                
        $promos = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->get();
        $member_baru = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','!=',null)
                        ->get();
        $member_panjang = Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','=',null)
                        ->get();
        
        
        $totalmembers = 0;
        $totalnonpromos = 0;
        $totalpromos = 0;
        $totalmemberbaru = 0;
        $totalmemberpanjang = 0;
        foreach ($members as $member) {
            # code...
            $totalmembers = $totalmembers + $member->total;
        }
        foreach ($nonpromos as $nonpromo) {
            # code...
            $totalnonpromos = $totalnonpromos + $nonpromo->total;
            
        }
        
         foreach ($promos as $promo) {
            # code...
            $totalpromos = $totalpromos + $promo->total;
            
        }
        foreach ($member_baru as $member) {
            # code...
            $totalmemberbaru = $totalmemberbaru + $member->total;
            
        }
        foreach ($member_panjang as $member) {
            # code...
            $totalmemberpanjang = $totalmemberpanjang + $member->total;
            
        }

        $pdf = PDF::loadView('dashboard.report.promo.member_excel',compact('totalmembers','totalnonpromos','totalpromos','totalmemberbaru','totalmemberpanjang'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}