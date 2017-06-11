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
use PDF;
use Excel;
class usiamemberextdetailController extends Controller
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
        $usiamember = Member::orderBy('id','desc')->get();
        
        return view('dashboard.report.usiamemberextdetail.member',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('usiamember',$usiamember)
        ;
    }
    public function searchmember(Request $request)
    {
        $nama_gym = $request->get('lokasi');
        if($nama_gym==0)
        {
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
        $usiamember = Member::orderBy('id','desc')->get();
        
        return view('dashboard.report.usiamemberextdetail.member',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('usiamember',$usiamember)
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
            # code...
           
            if($request->lokasi == 1||$request->lokasi == 3||$request->lokasi == 5){
                if($request->lokasi == 1){
                    $gyms = Gym::orderBy('title','ASC')->get();
                }else if($request->lokasi == 3){
                    $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugym)->get();   
                }else if($request->lokasi == 5){
                    $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugymku)->get();   
                }
                return view('dashboard.report.usiamemberextdetail.searchmember',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('gyms',$gyms)
            ;
            }else if($request->get('lokasi') == 2||$request->get('lokasi') == 4){
                if($request->get('lokasi') == 2){
                    $zonas = Zona::get();
                }else{
                    $zonas = Zona::whereIn('id',$tertentuzona)->get();
                } 
                return view('dashboard.report.usiamemberextdetail.zonamember',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('zonas',$zonas)
                ;
            }
        }
    }

    public function link_zonausia(Request $request, $id)
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
            # code...
           
            $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();   

                return view('dashboard.report.usiamemberextdetail.link_zonausia',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
                ->with('currentdate',$currentdate)
                ->with('backdate',$backdate)
                ->with('tofiftieen',$tofifteen)
                ->with('gyms',$gyms)
            ;
    }

    public function exportExcel(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        return Excel::create('Report Member All', function($excel) use ($currentdate,$backdate,$date30DaysBack,$tofifteen){
            $excel->sheet('New sheet', function($sheet) use ($currentdate,$backdate,$date30DaysBack,$tofifteen){
                $sheet->loadView('dashboard.report.usiamemberextdetail.member_excel')->with('currentdate',$currentdate)
                                                                            ->with('backdate',$backdate)
                                                                            ->with('date30DaysBack',$date30DaysBack)
                                                                            ->with('tofifteen',$tofifteen);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $pdf = PDF::loadView('dashboard.report.usiamemberextdetail.member_excel',compact('currentdate','backdate','date30DaysBack','tofifteen'));
        $pdf->setPaper('A3', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}
