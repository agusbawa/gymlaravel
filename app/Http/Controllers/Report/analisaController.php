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
use App\Attendance;
use DB;
use PDF;
use Excel;
class analisaController extends Controller
{
    public function index(Request $request)
    {
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
        return view('dashboard.report.analisapendapatan.index',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('gym',$gym)
        ->with('zona',$zona)
        ;
    }

    public function searchmember(Request $request)
    {
        $nama_gym = $request->lokasi;
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
        return view('dashboard.report.analisapendapatan.index',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('gym',$gym)
        ->with('zona',$zona)
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
            if($request->lokasi == 1){
                        $gyms = Gym::orderBy('title','ASC')->get();
                         $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            return view('dashboard.report.analisapendapatan.searchmember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
             ->with('gym',$gym)
            ->with('zona',$zona)
            ;
                      
                    }else if($request->lokasi == 3){
                        $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugym)->get();
                         $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            return view('dashboard.report.analisapendapatan.searchmember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ;  
                       
                    }else if($request->lokasi == 5){
                        $gyms = Gym::orderBy('title','ASC')->whereIn('id',$tertentugymku)->get();  
                         $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            return view('dashboard.report.analisapendapatan.searchmember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ;
                      
                    }else if($request->lokasi == 2){
                        $zonas = Zona::orderBy('title','ASC')->get();
                         $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            return view('dashboard.report.analisapendapatan.zonamember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ;
                    
                    }else if($request->lokasi == 4){
                        $zonas = Zona::orderBy('title','ASC')->whereIn('id',$tertentuzona)->get();
                         $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            return view('dashboard.report.analisapendapatan.zonamember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gym',$gym)
            ->with('zona',$zona)
            ;
                 
                } 
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

                    $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();
                     $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        return view('dashboard.report.analisapendapatan.link_zonamember',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
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
        return Excel::create('Report Member All', function($excel) use ($currentdate,$backdate){
            $excel->sheet('New sheet', function($sheet) use ($currentdate,$backdate){
                $sheet->loadView('dashboard.report.analisapendapatan.member_excel')->with('currentdate',$currentdate)
                                                                            ->with('backdate',$backdate);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();

        $pdf = PDF::loadView('dashboard.report.analisapendapatan.member_excel',compact('currentdate','backdate'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
   
}