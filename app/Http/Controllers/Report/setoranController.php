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
class setoranController extends Controller
{
    public function index(Request $request)
    {
        # code...
        $tahun_gym = "";
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
        $gyms = Gym::orderBy('id','desc')->get();
        
        
       
        return view('dashboard.report.rekapslipsetoran.index',compact('tahun_gym','nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('gyms',$gyms)
        ;
    }
    public function search(Request $request)
    {
        # code...
        $nama_gym = $request->lokasi;
        if($nama_gym==0)
        {
            # code...
        $tahun_gym = "";
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
        $gyms = Gym::orderBy('id','desc')->get();
        
        
       
        return view('dashboard.report.rekapslipsetoran.index',compact('tahun_gym','nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
        ->with('gyms',$gyms)
        ;
        }else{
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


                $gyms = DB::table('gyms')->get();
       
      
           
             return view('dashboard.report.rekapslipsetoran.search',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gyms',$gyms)
            ;
        }
    }

    public function exportExcel(Request $request)
    {
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        $members = Member::get();
        return Excel::create('Report Member All', function($excel) use ($members,$gym,$zona){
            $excel->sheet('New sheet', function($sheet) use ($members,$gym,$zona){
                $sheet->loadView('dashboard.report.rekapslipsetoran.member_excel')->with('members',$members)
                                                                            ->with('gym',$gym)
                                                                            ->with('zona',$zona);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        $members = Member::get();

        $pdf = PDF::loadView('dashboard.report.rekapslipsetoran.member_excel',compact('members','gym','zona'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}