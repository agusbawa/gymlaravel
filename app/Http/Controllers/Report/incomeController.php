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
use App\Personaltrainer;
use App\Kantin;
use App\Memberharian;   
use DB;
use View;
use PDF;
use TrasactionPayment;
use Excel;
class incomeController extends Controller
{
    public function view_incomevs(Request $request)
    {
        $nama_gym = 0;
        if($request->range){
            $range     =   explode(" - ", $request->get('range'));
        $backdate      =   date("Y-m-d", strtotime($range[0]));
        $currentdate      =   date("Y-m-d", strtotime($range[1]));
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }else{
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }
        $pendapatan = Transaction::orderBy('transactions.id','asc')->whereBetween('created_at',[$backdate,$currentdate]);
        $total = 0;
        foreach($pendapatan->get() as $trans){
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
        foreach($newsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalnewsatu = $totalnewsatu + $new->total;
        }
        
         
        $totalnewtiga = 0;
        foreach($newtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalnewtiga = $totalnewtiga + $new->total;
        }
       
        $newempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewempat = 0;
        foreach($newempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewempat = $totalnewempat + $new->total;
        }
        $newlima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewlima = 0;
        foreach($newlima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewlima = $totalnewlima + $new->total;
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
        foreach($panjangsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalpanjangsatu = $totalpanjangsatu + $new->total;
        }
        
         
        $totalpanjangtiga = 0;
        foreach($panjangtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalpanjangtiga = $totalpanjangtiga + $new->total;
        }
       
        $panjangempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjangempat = 0;
        foreach($panjangempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjangempat = $totalpanjangempat + $new->total;
        }
        $panjanglima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjanglima = 0;
        foreach($panjanglima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjanglima = $totalpanjanglima + $new->total;
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
        
       
        if($request->get('lokasi')==2){
            $nama_gym = $request->get('lokasi');
                $pendapatan = Transaction::orderBy('transactions.id','asc')->whereBetween('created_at',[$backdate,$currentdate]);
        $total = 0;
        foreach($pendapatan->get() as $trans){
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
        foreach($newsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalnewsatu = $totalnewsatu + $new->total;
        }
        
         
        $totalnewtiga = 0;
        foreach($newtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalnewtiga = $totalnewtiga + $new->total;
        }
       
        $newempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewempat = 0;
        foreach($newempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewempat = $totalnewempat + $new->total;
        }
        $newlima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewlima = 0;
        foreach($newlima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewlima = $totalnewlima + $new->total;
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
        foreach($panjangsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalpanjangsatu = $totalpanjangsatu + $new->total;
        }
        
         
        $totalpanjangtiga = 0;
        foreach($panjangtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalpanjangtiga = $totalpanjangtiga + $new->total;
        }
       
        $panjangempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjangempat = 0;
        foreach($panjangempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjangempat = $totalpanjangempat + $new->total;
        }
        $panjanglima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjanglima = 0;
        foreach($panjanglima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjanglima = $totalpanjanglima + $new->total;
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
                $gym =Zona::get();
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
            return view('dashboard.report.pendapatan.gympendapatan')->with('nama_gym',$nama_gym);
        }
        return view('dashboard.report.pendapatan.member')->with('nama_gym',$nama_gym);
    }
    public function general()
    {
        # code...
    }
    public function zona_incomevs(Request $request, $id)
    {
        
        $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
            $pilih_kat = $request->get('pilih_kat');
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
            $gyms = DB::table('gyms')->get();
            $zonas = DB::table('zonas')->get();
            // dd($request);
            $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            
            if($rangeku!==null){
                $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));                    

                return view('dashboard.report.new.income.zona_incomevs',compact('range','range_1','title_gym','start_date','end_date','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            }else{
                $start_date = '';
                $end_date = '';
                $report_expired = '';
                $report_expired_1 = '';
                $report_extends = '';
                $report_extends_1 = '';
                $per_expired = '';
                $per_extends = '';
                $no = "";
                $no_1 = "";
                return view('dashboard.report.new.income.zona_incomevs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            }   
    }

    public function exportExcel(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $start_date = '';
        $end_date = '';
        return Excel::create('Report Member All', function($excel) use ($title_gym,$start_date,$end_date){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$start_date,$end_date){
                $sheet->loadView('dashboard.report.new.income.member_excel')->with('title_gym',$title_gym)
                                                                            ->with('start_date',$start_date)
                                                                            ->with('end_date',$end_date);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $start_date = '';
        $end_date = '';
        $pdf = PDF::loadView('dashboard.report.new.income.member_excel',compact('title_gym','start_date','end_date'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}
