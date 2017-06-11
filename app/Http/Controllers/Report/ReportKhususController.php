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
use App\Setoranbank;
use App\TargetGym;
use DB;
use PDF;
use Excel;
class ReportKhususController extends Controller
{
    public function index(Request $request)
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
        $target = TargetGym::orderBy('id','DESC')->get();
        $totalextend = 0;
        $totalharian = 0;
        $totalpersonal = 0;
        $totaljmlextend = 0;
        $totaljmlreturner = 0;
        $totalreturner = 0;
         $totalnewmember = 0;
            $totalnewmember_price = 0;
            $total =0;
            $totalkantin = 0;
            $total_omset = 0;
            
        foreach ($target as $extend) {
            # code...
           
            $totalextend = $totalextend + $extend->extends_per_month_price;
            $totaljmlextend = $totaljmlextend + $extend->exteds_per_month;
            $totaljmlreturner = $totalreturner + $extend->returner;
            $totalreturner = $totalreturner + $extend->returner_price;
            $totalnewmember = $totalnewmember + $extend->new_member;
            $totalnewmember_price = $totalnewmember_price + $extend->new_member_price;
            $totalharian = $totalharian + $extend->harian;
            $totalpersonal = $totalpersonal + $extend->personal_trainer_id;
            $total = $total + $extend->total;
            $totalkantin = $totalkantin + $extend->kantin;
            $total_omset = $total_omset + $extend->total_omset;

            
        }
        
        return view('dashboard.report.reportkhusus.index',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('totalextend',$totalextend)
        ->with('totaljmlextend',$totaljmlextend)
        ->with('totaljmlreturner',$totaljmlreturner)
        ->with('totalreturner',$totalreturner)
         ->with('totalnewmember',$totalnewmember)
        ->with('totalnewmember_price',$totalnewmember_price)
        ->with('total',$total)
        ->with('totalharian',$totalharian)
        ->with('totalpersonal',$totalpersonal)
        ->with('totalkantin',$totalkantin)
        ->with('total_omset',$total_omset)
        ;
    }
    public function search(Request $request)
    {
        $nama_gym = $request->get('lokasi');
        if($nama_gym==0){
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
        $target = TargetGym::orderBy('id','DESC')->get();
        $totalextend = 0;
        $totalharian = 0;
        $totalpersonal = 0;
        $totaljmlextend = 0;
        $totaljmlreturner = 0;
        $totalreturner = 0;
         $totalnewmember = 0;
            $totalnewmember_price = 0;
            $total =0;
            $totalkantin = 0;
            $total_omset = 0;
            
        foreach ($target as $extend) {
            # code...
           
            $totalextend = $totalextend + $extend->extends_per_month_price;
            $totaljmlextend = $totaljmlextend + $extend->exteds_per_month;
            $totaljmlreturner = $totalreturner + $extend->returner;
            $totalreturner = $totalreturner + $extend->returner_price;
            $totalnewmember = $totalnewmember + $extend->new_member;
            $totalnewmember_price = $totalnewmember_price + $extend->new_member_price;
            $totalharian = $totalharian + $extend->harian;
            $totalpersonal = $totalpersonal + $extend->personal_trainer_id;
            $total = $total + $extend->total;
            $totalkantin = $totalkantin + $extend->kantin;
            $total_omset = $total_omset + $extend->total_omset;

            
        }
        
        return view('dashboard.report.reportkhusus.index',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('totalextend',$totalextend)
        ->with('totaljmlextend',$totaljmlextend)
        ->with('totaljmlreturner',$totaljmlreturner)
        ->with('totalreturner',$totalreturner)
         ->with('totalnewmember',$totalnewmember)
        ->with('totalnewmember_price',$totalnewmember_price)
        ->with('total',$total)
        ->with('totalharian',$totalharian)
        ->with('totalpersonal',$totalpersonal)
        ->with('totalkantin',$totalkantin)
        ->with('total_omset',$total_omset)
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
            $totalextend = 0;
            $totalharian = 0;
            $totalpersonal = 0;
            $totaljmlextend = 0;
            $totaljmlreturner = 0;
            $totalreturner = 0;
             $totalnewmember = 0;
                $totalnewmember_price = 0;
                $total =0;
                $totalkantin = 0;
                $total_omset = 0;
                $target = TargetGym::orderBy('id','DESC')->get();
                
            foreach ($target as $extend) {
                # code...
               
                $totalextend = $totalextend + $extend->extends_per_month_price;
                $totaljmlextend = $totaljmlextend + $extend->exteds_per_month;
                $totaljmlreturner = $totalreturner + $extend->returner;
                $totalreturner = $totalreturner + $extend->returner_price;
                $totalnewmember = $totalnewmember + $extend->new_member;
                $totalnewmember_price = $totalnewmember_price + $extend->new_member_price;
                $totalharian = $totalharian + $extend->harian;
                $totalpersonal = $totalpersonal + $extend->personal_trainer_id;
                $total = $total + $extend->total;
                $totalkantin = $totalkantin + $extend->kantin;
                $total_omset = $total_omset + $extend->total_omset;

                
            }
            # code...
           
            if($request->get('lokasi') == 1||$request->get('lokasi') == 3||$request->get('lokasi') == 5){
                if($request->get('lokasi') == 1){
                    $gyms = gym::get();
                }else if($request->get('lokasi') == 3){
                    $gyms = gym::whereIn('id',$tertentugym)->get();
                }else if($request->get('lokasi') == 5){
                    $gyms = gym::whereIn('id',$tertentugymku)->get();
                }
                return view('dashboard.report.reportkhusus.searchreport',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('gyms',$gyms)
                ->with('totalextend',$totalextend)
            ->with('totaljmlextend',$totaljmlextend)
            ->with('totaljmlreturner',$totaljmlreturner)
            ->with('totalreturner',$totalreturner)
             ->with('totalnewmember',$totalnewmember)
            ->with('totalnewmember_price',$totalnewmember_price)
            ->with('total',$total)
            ->with('totalharian',$totalharian)
            ->with('totalpersonal',$totalpersonal)
            ->with('totalkantin',$totalkantin)
            ->with('total_omset',$total_omset)
            ;
            }else if($request->get('lokasi') == 2||$request->get('lokasi') == 4){
                if($request->get('lokasi') == 2){
                    $zonas = Zona::get();
                }else{
                    $zonas = Zona::whereIn('id',$tertentuzona)->get();
                }    
                 return view('dashboard.report.reportkhusus.zonakhusus',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('zonas',$zonas)
                ->with('totalextend',$totalextend)
            ->with('totaljmlextend',$totaljmlextend)
            ->with('totaljmlreturner',$totaljmlreturner)
            ->with('totalreturner',$totalreturner)
             ->with('totalnewmember',$totalnewmember)
            ->with('totalnewmember_price',$totalnewmember_price)
            ->with('total',$total)
            ->with('totalharian',$totalharian)
            ->with('totalpersonal',$totalpersonal)
            ->with('totalkantin',$totalkantin)
            ->with('total_omset',$total_omset)
                ;
            }
        }
    }

    public function link_zonakhusus(Request $request, $id)
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
        $totalextend = 0;
        $totalharian = 0;
        $totalpersonal = 0;
        $totaljmlextend = 0;
        $totaljmlreturner = 0;
        $totalreturner = 0;
         $totalnewmember = 0;
            $totalnewmember_price = 0;
            $total =0;
            $totalkantin = 0;
            $total_omset = 0;
            $target = TargetGym::orderBy('id','DESC')->get();
            
        foreach ($target as $extend) {
            # code...
           
            $totalextend = $totalextend + $extend->extends_per_month_price;
            $totaljmlextend = $totaljmlextend + $extend->exteds_per_month;
            $totaljmlreturner = $totalreturner + $extend->returner;
            $totalreturner = $totalreturner + $extend->returner_price;
            $totalnewmember = $totalnewmember + $extend->new_member;
            $totalnewmember_price = $totalnewmember_price + $extend->new_member_price;
            $totalharian = $totalharian + $extend->harian;
            $totalpersonal = $totalpersonal + $extend->personal_trainer_id;
            $total = $total + $extend->total;
            $totalkantin = $totalkantin + $extend->kantin;
            $total_omset = $total_omset + $extend->total_omset;

            
        }
        # code...
 
                $gyms = gym::where('zona_id',$id)->get();

            return view('dashboard.report.reportkhusus.searchreport',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gyms',$gyms)
            ->with('totalextend',$totalextend)
        ->with('totaljmlextend',$totaljmlextend)
        ->with('totaljmlreturner',$totaljmlreturner)
        ->with('totalreturner',$totalreturner)
         ->with('totalnewmember',$totalnewmember)
        ->with('totalnewmember_price',$totalnewmember_price)
        ->with('total',$total)
        ->with('totalharian',$totalharian)
        ->with('totalpersonal',$totalpersonal)
        ->with('totalkantin',$totalkantin)
        ->with('total_omset',$total_omset)
        ;
    }

    public function exportExcel(Request $request)
    {
        $totalextend = 0;
        $totalharian = 0;
        $totalpersonal = 0;
        $totaljmlreturner = 0;
        $totalnewmember = 0;
        $total = 0;
        $totalkantin = 0;
        $total_omset = 0;
        return Excel::create('Report Member All', function($excel) use ($totalextend,$totalharian,$totalpersonal,$totaljmlreturner,$totalnewmember,$total,$totalkantin,$total_omset){
            $excel->sheet('New sheet', function($sheet) use ($totalextend,$totalharian,$totalpersonal,$totaljmlreturner,$totalnewmember,$total,$totalkantin,$total_omset){
                $sheet->loadView('dashboard.report.reportkhusus.member_excel')->with('totalextend',$totalextend)
                                                                            ->with('totalharian',$totalharian)
                                                                            ->with('totalpersonal',$totalpersonal)
                                                                            ->with('totaljmlreturner',$totaljmlreturner)
                                                                            ->with('totalnewmember',$totalnewmember)
                                                                            ->with('total',$total)
                                                                            ->with('totalkantin',$totalkantin)
                                                                            ->with('total_omset',$total_omset);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        $members = Member::get();

        $pdf = PDF::loadView('dashboard.report.reportkhusus.member_excel',compact('totalextend','totalharian','totalpersonal','totaljmlreturner','totalnewmember','total','totalkantin','total_omset'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}