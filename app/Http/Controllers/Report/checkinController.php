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
class checkinController extends Controller
{
    public function member(Request $request)
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
        $currenthour = Carbon::now()->toDateString();
        $currentten = ($currenthour.' 10:00:00');
        $currentsix = ($currenthour.' 16:00:00');
        $currentnine = ($currenthour.' 19:00:00');
        $currentone = ($currenthour.' 21:00:00');
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $checkin = Attendance::get();
        return view('dashboard.report.chekinchekout.index',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofifteen',$tofifteen)
        ->with('currentten',$currentten)
        ->with('currentsix',$currentsix)
        ->with('currentnine',$currentnine)
        ->with('currentone',$currentone)
        ;
    }
    public function searchmember(Request $request)
    {
        $nama_gym = $request->get('lokasi');
        if($nama_gym==0){
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
            $currenthour = Carbon::now()->toDateString();
            $currentten = ($currenthour.' 10:00:00');
            $currentsix = ($currenthour.' 16:00:00');
            $currentnine = ($currenthour.' 19:00:00');
            $currentone = ($currenthour.' 21:00:00');
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            $checkin = Attendance::get();
            return view('dashboard.report.chekinchekout.index',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofifteen',$tofifteen)
            ->with('currentten',$currentten)
            ->with('currentsix',$currentsix)
            ->with('currentnine',$currentnine)
            ->with('currentone',$currentone)
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
            if($request->periode== null){
            $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            }else{
            $range                  =   explode(" - ", $request->get('range'));
            $backdate      =   date("Y-m-d", strtotime($range[0]));
            $currentdate      =   date("Y-m-d", strtotime($range[1]));
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            }
            if($nama_gym == 1){
                    $gyms = gym::get();
            }else if($nama_gym == 2){
                    $gyms = Zona::get();
            }else if($nama_gym == 3){
                    $gyms = gym::whereIn('id',$tertentugym)->get();
            }else if($nama_gym == 4){
                    $gyms = Zona::whereIn('id',$tertentuzona)->get();
            }else if($nama_gym == 5){
                    $gyms = gym::whereIn('id',$tertentugymku)->get();
            }
            $currenthour = Carbon::now()->toDateString();
            
            $currentten = ($currenthour.' 10:00:00');
            $currentten = ($currenthour.' 07:00:00');
            $currentsix = ($currenthour.' 16:00:00');
            $currentnine = ($currenthour.' 19:00:00');
            $currentone = ($currenthour.' 21:00:00');
            return view('dashboard.report.chekinchekout.searchmember',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('gyms',$gyms)
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofifteen',$tofifteen)
            ->with('currentten',$currentten)
            ->with('currentsix',$currentsix)
            ->with('currentnine',$currentnine)
            ->with('currentone',$currentone)
            ;
        }
    }

    public function link_zonacheckin(Request $request, $id)
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
            if($request->periode== null){
            $currentdate = Carbon::now()->toDateTimeString();
            $backdate = Carbon::parse('-30 days')->toDateTimeString();
            $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            }else{
            $range                  =   explode(" - ", $request->get('range'));
            $backdate      =   date("Y-m-d", strtotime($range[0]));
            $currentdate      =   date("Y-m-d", strtotime($range[1]));
            $tofifteen = Carbon::parse('15 days')->toDateTimeString();
            }
         
            $gyms = gym::where('zona_id',$id)->get();

            $currenthour = Carbon::now()->toDateString();
            
            $currentten = ($currenthour.' 10:00:00');
            $currentten = ($currenthour.' 07:00:00');
            $currentsix = ($currenthour.' 16:00:00');
            $currentnine = ($currenthour.' 19:00:00');
            $currentone = ($currenthour.' 21:00:00');
            return view('dashboard.report.chekinchekout.link_checkin',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('gyms',$gyms)
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofifteen',$tofifteen)
            ->with('currentten',$currentten)
            ->with('currentsix',$currentsix)
            ->with('currentnine',$currentnine)
            ->with('currentone',$currentone)
            ;
    }

    public function exportExcel(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $currenthour = Carbon::now()->toDateString();
        $currentten = ($currenthour.' 10:00:00');
        $currentsix = ($currenthour.' 16:00:00');
        $currentnine = ($currenthour.' 19:00:00');
        $currentone = ($currenthour.' 21:00:00');
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        return Excel::create('Report Member All', function($excel) use ($currentdate,$currenthour,$currentten,$currentsix,$currentnine,$currentone,$backdate){
            $excel->sheet('New sheet', function($sheet) use ($currentdate,$currenthour,$currentten,$currentsix,$currentnine,$currentone,$backdate){
                $sheet->loadView('dashboard.report.chekinchekout.member_excel')->with('currentdate',$currentdate)
                                                                            ->with('currenthour',$currenthour)
                                                                            ->with('currentten',$currentten)
                                                                            ->with('currentsix',$currentsix)
                                                                            ->with('currentnine',$currentnine)
                                                                            ->with('currentone',$currentone)
                                                                            ->with('currentten',$currentten)
                                                                            ->with('backdate',$backdate);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $currentdate = Carbon::now()->toDateTimeString();
        $currenthour = Carbon::now()->toDateString();
        $currentten = ($currenthour.' 10:00:00');
        $currentsix = ($currenthour.' 16:00:00');
        $currentnine = ($currenthour.' 19:00:00');
        $currentone = ($currenthour.' 21:00:00');
        $backdate = Carbon::parse('-30 days')->toDateTimeString();

        $pdf = PDF::loadView('dashboard.report.chekinchekout.member_pdf',compact('members','gym','zona'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}