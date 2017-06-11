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
class penbybayarController extends Controller
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
        ->get()
        ;
         $paketsatu = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Cash')
        ->get()
        ;
        $paketdua = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','EDC')
        ->get()
        ;
        $pakettiga = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Transfer')
        ->get()
        ;
            $total = 0;
            $satu = 0;
            $dua = 0;
            $tiga = 0;
            $empat = 0;
    
            foreach ($paketsatu as $hah) {
                $satu = $satu + $hah->total;
            }
            foreach ($paketdua as $pendapatan => $hah) {
                $dua = $dua + $hah->total;
            }
            foreach ($pakettiga as $pendapatan => $hah) {
                $tiga = $tiga + $hah->total;
            }
            
        $total = $satu + $dua + $tiga;
    
        return view('dashboard.report.pendapatan_bayar.member',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
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
    
        return view('dashboard.report.pendapatan_bayar.member',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
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
                return view('dashboard.report.pendapatan_bayar.memberbaru',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
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
            }else if($request->get('lokasi') == 2){
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
                 return view('dashboard.report.pendapatan_bayar.memberbaru',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
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
            ->where('transactions.payment_method','=','Transfer')
            
            ->get()
            ;
            $paketdua = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
            ->where('transactions.payment_method','=','Cash')
            ->get()
            ;
            $pakettiga = Transaction::whereBetween('created_at',[$backdate,$currentdate])
            ->join('package_prices','transactions.package_price_id','=','package_prices.id')
             ->where('transactions.payment_method','=','IPAYMU')
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
                
                 return view('dashboard.report.pendapatan_bayar.carabayar',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
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
        
            return view('dashboard.report.pendapatan_bayar.memberbaru',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
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
            return view('dashboard.report.pendapatan_bayar.link_zonapendapatan',compact('gyms','nama_gym','gym','zona','tertentugym','tertentuzona'))
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
        ->get()
        ;
         $paketsatu = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Cash')
        ->get()
        ;
        $paketdua = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','EDC')
        ->get()
        ;
        $pakettiga = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Transfer')
        ->get()
        ;
            $total = 0;
            $satu = 0;
            $dua = 0;
            $tiga = 0;
    
            foreach ($paketsatu as $hah) {
                $satu = $satu + $hah->total;
            }
            foreach ($paketdua as $pendapatan => $hah) {
                $dua = $dua + $hah->total;
            }
            foreach ($pakettiga as $pendapatan => $hah) {
                $tiga = $tiga + $hah->total;
            }
            
        $total = $satu + $dua + $tiga;
        return Excel::create('Report Member All', function($excel) use ($total,$satu,$dua,$tiga){
            $excel->sheet('New sheet', function($sheet) use ($total,$satu,$dua,$tiga){
                $sheet->loadView('dashboard.report.pendapatan_bayar.member_excel')->with('total',$total)
                                                                            ->with('satu',$satu)
                                                                            ->with('dua',$dua)
                                                                            ->with('tiga',$tiga);
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
        ->get()
        ;
         $paketsatu = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Cash')
        ->get()
        ;
        $paketdua = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','EDC')
        ->get()
        ;
        $pakettiga = Transaction::join('transaksi_payments','transactions.id','=','transaksi_payments.transaction_id')
            ->where('transaksi_payments.payment_method','=','Transfer')
        ->get()
        ;
            $total = 0;
            $satu = 0;
            $dua = 0;
            $tiga = 0;
    
            foreach ($paketsatu as $hah) {
                $satu = $satu + $hah->total;
            }
            foreach ($paketdua as $pendapatan => $hah) {
                $dua = $dua + $hah->total;
            }
            foreach ($pakettiga as $pendapatan => $hah) {
                $tiga = $tiga + $hah->total;
            }
            
        $total = $satu + $dua + $tiga;
        $pdf = PDF::loadView('dashboard.report.pendapatan_bayar.member_excel',compact('total','satu','dua','tiga'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}
