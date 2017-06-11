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
use View;
use App\Transaction;
use App\Memberharian;
use App\Kantin;
use App\Personaltrainer;
use DB;
use PDF;
use Excel;
class pendapatanController extends Controller
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
        $pendapatans = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->get()
        ;
         $paketsatu = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','30')
        ->get()
        ;
        $paketdua = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','90')
        ->get()
        ;
        $pakettiga = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','180')
        ->get()
        ;
        $paketpat = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','365')
        ->get()
        ;
            $total = 0;
            $satu = 0;
            $dua = 0;
            $tiga = 0;
            $empat = 0;
            foreach ($pendapatans as $pendapatan => $hah) {
                $total = $total + $hah->price;
            }
            foreach ($paketsatu as $pendapatan => $hah) {
                $satu = $satu + $hah->price;
            }
            foreach ($pakettiga as $pendapatan => $hah) {
                $tiga = $tiga + $hah->price;
            }
            foreach ($paketpat as $pendapatan => $hah) {
                $empat = $empat + $hah->price;
            }
    
        return view('dashboard.report.pendapatan.member',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('pendapatans',$pendapatans)
        ->with('total',$total)
        ->with('satu',$satu)
        ->with('dua',$dua)
        ->with('tiga',$tiga)
        ->with('empat',$empat)
        ;
    }
    public function searchmember(Request $request)
    {
        $nama_gym = $request->get('lokasi');
        if($nama_gym==0){
            # code...
        return redirect('/u/report/income');
        }else{
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
            if($nama_gym==1){
                $gyms = DB::table('gyms')->get();
            }else if($nama_gym==2){
                $gyms = DB::table('zonas')->get();
            }else if($nama_gym==3){
                $gyms = DB::table('gyms')->whereIn('id',$tertentugym)->get();
            }else if($nama_gym==4){
                $gyms = DB::table('zonas')->whereIn('id',$tertentuzona)->get();
            }else if($nama_gym==5){
                $gyms = DB::table('gyms')->whereIn('id',$tertentugymku)->get();
            }
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
           
            if($request->get('lokasi') == 1||$request->get('lokasi') == 3||$request->get('lokasi') == 5){
                if($request->get('lokasi') == 1){
                    $pendapatans = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->get()
                    ;
                     $paketsatu = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->where('package_prices.day','=','30')
                    ->get()
                    ;
                    $paketdua = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->where('package_prices.day','=','90')
                    ->get()
                    ;
                    $pakettiga = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->where('package_prices.day','=','180')
                    ->get()
                    ;
                    $paketpat = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->where('package_prices.day','=','365')
                    ->get()
                    ;
                }else if ($request->get('lokasi') == 3){
                    $pendapatans = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugym)
                    ->get()
                    ;
                    $paketsatu = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugym)
                    ->where('package_prices.day','=','30')
                    ->get()
                    ;
                    $paketdua = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugym)
                    ->where('package_prices.day','=','90')
                    ->get()
                    ;
                    $pakettiga = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugym)
                    ->where('package_prices.day','=','180')
                    ->get()
                    ;
                    $paketpat = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugym)
                    ->where('package_prices.day','=','365')
                    ->get()
                    ;
                }else if ($request->get('lokasi') == 5){
                    $pendapatans = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugymku)
                    ->get()
                    ;
                    $paketsatu = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugymku)
                    ->where('package_prices.day','=','30')
                    ->get()
                    ;
                    $paketdua = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugymku)
                    ->where('package_prices.day','=','90')
                    ->get()
                    ;
                    $pakettiga = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugymku)
                    ->where('package_prices.day','=','180')
                    ->get()
                    ;
                    $paketpat = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                        ->join('members','members.id','=','transactions.member_id')
                    ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                    ->whereIn('transactions.gym_id',$tertentugymku)
                    ->where('package_prices.day','=','365')
                    ->get()
                    ;
                }
                $total = 0;
                $satu = 0;
                $dua = 0;
                $tiga = 0;
                $empat = 0;
                foreach ($pendapatans as $pendapatan => $hah) {
                    $total = $total + $hah->price;
                }
                foreach ($paketsatu as $pendapatan => $hah) {
                    $satu = $satu + $hah->price;
                }
                foreach ($pakettiga as $pendapatan => $hah) {
                    $tiga = $tiga + $hah->price;
                }
                foreach ($paketpat as $pendapatan => $hah) {
                    $empat = $empat + $hah->price;
                }
                return view('dashboard.report.pendapatan.memberbaru',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('pendapatans',$pendapatans)
                ->with('total',$total)
                ->with('satu',$satu)
                ->with('dua',$dua)
                ->with('tiga',$tiga)
                ->with('empat',$empat)
                ;
            }else if($request->get('lokasi') == 2 || $request->get('lokasi')==4){
                $pendapatans = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->get()
            ;
             $paketsatu = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->where('package_prices.day','=','30')
            ->get()
            ;
            $paketdua = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->where('package_prices.day','=','90')
            ->get()
            ;
            $pakettiga = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->where('package_prices.day','=','180')
            ->get()
            ;
            $paketpat = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->where('package_prices.day','=','365')
            ->get()
            ;
                $total = 0;
                $satu = 0;
                $dua = 0;
                $tiga = 0;
                $empat = 0;
                foreach ($pendapatans as $pendapatan => $hah) {
                    $total = $total + $hah->total;
                }
                foreach ($paketsatu as $pendapatan => $hah) {
                    $satu = $satu + $hah->total;
                }
                foreach ($pakettiga as $pendapatan => $hah) {
                    $tiga = $tiga + $hah->total;
                }
                foreach ($paketpat as $pendapatan => $hah) {
                    $empat = $empat + $hah->total;
                }
                 return view('dashboard.report.pendapatan.memberbaru',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('pendapatans',$pendapatans)
            ->with('total',$total)
            ->with('satu',$satu)
            ->with('dua',$dua)
            ->with('tiga',$tiga)
            ->with('empat',$empat)
            ;
                ;
            }
            else if($request->get('lokasi') == 3){
                $pendapatans = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->get()
            ;
             $paketsatu = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Transfer')
            
            ->get()
            ;
            $paketdua = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Cash')
            ->get()
            ;
            $pakettiga = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','IPAYMU')
            ->get()
            ;
           
            
                $total = 0;
                $satu = 0;
                $dua = 0;
                $tiga = 0;
                $empat = 0;
                foreach ($pendapatans as $pendapatan => $hah) {
                    $total = $total + $hah->price;
                }
                foreach ($paketsatu as $pendapatan => $hah) {
                    $satu = $satu + $hah->price;
                }
                foreach ($pakettiga as $pendapatan => $hah) {
                    $tiga = $tiga + $hah->price;
                }
                
                 return view('dashboard.report.pendapatan.carabayar',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('pendapatans',$pendapatans)
            ->with('total',$total)
            ->with('satu',$satu)
            ->with('dua',$dua)
            ->with('tiga',$tiga)
           
            ;
                
            }else{
                $nama_gym = 1;
                $pendapatangym = Transaction::orderBy('transactions.id','asc');
                $total = 0;
                foreach($pendapatangym->get() as $trans){
                    $total = $total+$trans->total;
                }
                
                
                $baru = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
                $newtotal = 0;
                
                $newsatu =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
                $newtiga =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
                foreach($baru->select('transactions.total')->get() as $new){
                    $newtotal = $newtotal + $new->total;
                }
            
            
            $totalnewsatu = 0;
                foreach($newsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('package_prices.price')->get() as $new){
                    $totalnewsatu = $totalnewsatu + $new->price;
                }
                
                
                $totalnewtiga = 0;
                foreach($newtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('package_prices.price')->get() as $new){
                    $totalnewtiga = $totalnewtiga + $new->price;
                }
            
                $newempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
                $totalnewempat = 0;
                foreach($newempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
                    $totalnewempat = $totalnewempat + $new->price;
                }
                $newlima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
                $totalnewlima = 0;
                foreach($newlima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
                    $totalnewlima = $totalnewlima + $new->price;
                }
        //------------------------------------------------------------
                $panjang = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
            
                $totalpanjang = 0;
                $panjangsatu =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
                $panjangtiga =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
                foreach($panjang->select('transactions.total')->get() as $new){
                    $totalpanjang = $totalpanjang + $new->total;
                }
            
            
            $totalpanjangsatu = 0;
                foreach($panjangsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('package_prices.price')->get() as $new){
                    $totalpanjangsatu = $totalpanjangsatu + $new->price;
                }
                
                
                $totalpanjangtiga = 0;
                foreach($panjangtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('package_prices.price')->get() as $new){
                    $totalpanjangtiga = $totalpanjangtiga + $new->price;
                }
            
                $panjangempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
                $totalpanjangempat = 0;
                foreach($panjangempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
                    $totalpanjangempat = $totalpanjangempat + $new->price;
                }
                $panjanglima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
                ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
                $totalpanjanglima = 0;
                foreach($panjanglima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
                    $totalpanjanglima = $totalpanjanglima + $new->price;
                }
                $memberharian = Memberharian::orderBy('members_harian.id','asc')->join('package_prices','package_prices.id','=','members_harian.package_id')->get();
                $totalharian = 0;
                foreach($memberharian as $harian){
                    $totalharian = $totalharian + $harian->price;
                }
                $kantin = Kantin::orderBy('kantin.id','asc')->get();
                $totalkantin = 0;
                foreach($kantin as $harian){
                    $totalkantin = $totalkantin + $harian->total;
                }
                $personaltrainer = Personaltrainer::orderBy('id','asc')->get();
                $totaltrainer = 0;
                foreach($personaltrainer as $harian){
                    $totaltrainer = $totaltrainer + $harian->fee_gym;
                }
                $total = $total + $totalharian + $totalkantin +  $totaltrainer;
               $gym =Gym::get();
        $zona = Zona::get();
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
                 View::share('totalkantin', $totalkantin);
            View::share('totaltrainer', $totaltrainer);
         View::share('tertentugym', $tertentugym);
         View::share('totalharian', $totalharian);
         View::share('newtotal', $newtotal);
         View::share('totalnewtiga', $totalnewtiga);
         View::share('totalnewempat', $totalnewempat);
         View::share('totalnewsatu', $totalnewsatu);
         View::share('totalpanjang', $totalpanjang);
          View::share('totalpanjangtiga', $totalpanjangtiga);
         View::share('totalpanjangempat', $totalpanjangempat);
         View::share('totalpanjangsatu', $totalpanjangsatu);
          View::share('totalpanjanglima', $totalpanjanglima);
         
         View::share('total', $total);
        View::share('tertentuzona', $tertentuzona);
        View::share('tertentugymku', $tertentugymku);
        View::share('gym', $gym);
        view::share('totalnewlima',$totalnewlima);
        View::share('zona', $zona);
        View::share('backdate', $backdate);
        View::share('currentdate', $currentdate);
        View::share('tofifteen', $tofifteen);   
        
            return view('dashboard.report.pendapatan.memberbaru',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
           
            ;
            }
        }
    }

    public function link_zonapendapatan(Request $request, $id)
    {
        $nama_gym = $request->get('lokasi');
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

            $gyms = DB::table('gyms')->where('zona_id',$id)->get();

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
       
                $pendapatans = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                ->join('members','members.id','=','transactions.member_id')
                ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                ->whereIn('transactions.gym_id',$tertentugym)
                ->get()
                ;
                $paketsatu = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                ->join('members','members.id','=','transactions.member_id')
                ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                ->whereIn('transactions.gym_id',$tertentugym)
                ->where('package_prices.day','=','30')
                ->get()
                ;
                $paketdua = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                ->join('members','members.id','=','transactions.member_id')
                ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                ->whereIn('transactions.gym_id',$tertentugym)
                ->where('package_prices.day','=','90')
                ->get()
                ;
                $pakettiga = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                ->whereIn('transactions.gym_id',$tertentugym)
                ->where('package_prices.day','=','180')
                ->get()
                ;
                $paketpat = Transaction::whereBetween('members.created_at',[$backdate,$currentdate])
                    ->join('members','members.id','=','transactions.member_id')
                ->join('package_prices','transactions.package_price_id','=','package_prices.id')
                ->whereIn('transactions.gym_id',$tertentugym)
                ->where('package_prices.day','=','365')
                ->get()
                ;

            $total = 0;
            $satu = 0;
            $dua = 0;
            $tiga = 0;
            $empat = 0;
            foreach ($pendapatans as $pendapatan => $hah) {
                $total = $total + $hah->price;
            }
            foreach ($paketsatu as $pendapatan => $hah) {
                $satu = $satu + $hah->price;
            }
            foreach ($pakettiga as $pendapatan => $hah) {
                $tiga = $tiga + $hah->price;
            }
            foreach ($paketpat as $pendapatan => $hah) {
                $empat = $empat + $hah->price;
            }
            return view('dashboard.report.pendapatan.link_zonapendapatan',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('pendapatans',$pendapatans)
            ->with('total',$total)
            ->with('satu',$satu)
            ->with('dua',$dua)
            ->with('tiga',$tiga)
            ->with('empat',$empat)
            ;
    }

    public function exportExcel(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $pendapatans = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->get()
        ;
         $paketsatu = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','30')
        ->get()
        ;
        $paketdua = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','90')
        ->get()
        ;
        $pakettiga = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','180')
        ->get()
        ;
        $paketpat = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','365')
        ->get()
        ;
            $total = 0;
            $satu = 0;
            $dua = 0;
            $tiga = 0;
            $empat = 0;
            foreach ($pendapatans as $pendapatan => $hah) {
                $total = $total + $hah->price;
            }
            foreach ($paketsatu as $pendapatan => $hah) {
                $satu = $satu + $hah->price;
            }
            foreach ($paketdua as $pendapatan => $hah) {
                $dua = $dua + $hah->price;
            }
            foreach ($pakettiga as $pendapatan => $hah) {
                $tiga = $tiga + $hah->price;
            }
            foreach ($paketpat as $pendapatan => $hah) {
                $empat = $empat + $hah->price;
            }
        return Excel::create('Report Member All', function($excel) use ($total,$satu,$dua,$tiga,$empat){
            $excel->sheet('New sheet', function($sheet) use ($total,$satu,$dua,$tiga,$empat){
                $sheet->loadView('dashboard.report.pendapatan_bayar.member_excel')->with('total',$total)
                                                                            ->with('satu',$satu)
                                                                            ->with('dua',$dua)
                                                                            ->with('tiga',$tiga)
                                                                            ->with('empat',$empat);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $pendapatans = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->get()
        ;
         $paketsatu = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','30')
        ->get()
        ;
        $paketdua = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','90')
        ->get()
        ;
        $pakettiga = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','180')
        ->get()
        ;
        $paketpat = Transaction::where('created_at','>=',$backdate)
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->where('package_prices.day','=','365')
        ->get()
        ;
            $total = 0;
            $satu = 0;
            $dua = 0;
            $tiga = 0;
            $empat = 0;
            foreach ($pendapatans as $pendapatan => $hah) {
                $total = $total + $hah->price;
            }
            foreach ($paketsatu as $pendapatan => $hah) {
                $satu = $satu + $hah->price;
            }
            foreach ($paketdua as $pendapatan => $hah) {
                $dua = $dua + $hah->price;
            }
            foreach ($pakettiga as $pendapatan => $hah) {
                $tiga = $tiga + $hah->price;
            }
            foreach ($paketpat as $pendapatan => $hah) {
                $empat = $empat + $hah->price;
            }
        $pdf = PDF::loadView('dashboard.report.pendapatan_bayar.member_excel',compact('total','satu','dua','tiga','empat'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}