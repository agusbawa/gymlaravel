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
class memberbaruController extends Controller
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
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        $members = Member::get();
        return view('dashboard.report.memberbaru.member',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))->with('members',$members)
         ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofifteen',$tofifteen)
        ;
    }
    public function searchmember(Request $request)
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
        $range                  =   explode(" - ", $request->get('periode'));
        $backdate      =   date("Y-m-d", strtotime($range[0]));
        $currentdate      =   date("Y-m-d", strtotime($range[1]));
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        }
        if($request->lokasi == 1||$request->lokasi == 3||$request->lokasi == 5){
            if($request->get('lokasi') == 1){
                $gyms = gym::get();
            }else if($request->get('lokasi') == 3){
                $gyms = gym::whereIn('id',$tertentugym)->get();
            }else if($request->get('lokasi') == 5){
                $gyms = gym::whereIn('id',$tertentugymku)->get();
            }
            return view('dashboard.report.memberbaru.searchmember',compact('nama_gym','gym','zona','tertentugym','tertentuzona','tertentugymku'))->with('gyms',$gyms)
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofifteen',$tofifteen);
        }else if($request->lokasi == 2||$request->lokasi == 4){
            if($request->get('lokasi') == 2){
                $zonas = Zona::get();
            }else{
                $zonas = Zona::whereIn('id',$tertentuzona)->get();
            }
            return view('dashboard.report.memberbaru.zonamember',compact('nama_gym','gym','zona','tertentugym','tertentuzona','tertentugymku'))->with('zonas',$zonas)
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofifteen',$tofifteen);
        }else{
            $members = Member::get();
            return view('dashboard.report.memberbaru.member',compact('nama_gym','gym','zona','tertentugym','tertentuzona','tertentugymku'))->with('members',$members)
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofifteen',$tofifteen);
        }
    }

    public function link_zonamemberbaru(Request $request, $id)
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
        if($request->range== null){
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

            return view('dashboard.report.memberbaru.link_zonamemberbaru',compact('nama_gym','gym','zona','tertentugym','tertentuzona','id'))->with('gyms',$gyms)
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofifteen',$tofifteen);
    }

    public function exportExcel(Request $request)
    {
        $gym = DB::table('gyms')->get();
        $zona = DB::table('zonas')->get();
        $members = Member::get();
        return Excel::create('Report Member All', function($excel) use ($members,$gym,$zona){
            $excel->sheet('New sheet', function($sheet) use ($members,$gym,$zona){
                $sheet->loadView('dashboard.report.memberbaru.member_excel')->with('members',$members)
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

        $pdf = PDF::loadView('dashboard.report.memberbaru.member_excel',compact('members','gym','zona'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function exportExcel_1(Request $request)
    {
        $id = $request->get('id');
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
        if($id==null){
            if($request->get('lokasi') == 1){
                $gyms = gym::get();
            }else if($request->get('lokasi') == 3){
                $gyms = gym::whereIn('id',$tertentugym)->get();
            }else if($request->get('lokasi') == 5){
                $gyms = gym::whereIn('id',$tertentugymku)->get();
            }else if($request->get('lokasi') == 2){
                $zonas = Zona::get();
            }else{
                $zonas = Zona::whereIn('id',$tertentuzona)->get();
            }
        }else{
            $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();  
        }
        if($request->lokasi == 1||$request->lokasi == 3||$request->lokasi == 5||$id!=null)
        {
            return Excel::create('Report Member All', function($excel) use ($gyms,$backdate,$currentdate,$tofifteen){
                $excel->sheet('New sheet', function($sheet) use ($gyms,$backdate,$currentdate,$tofifteen){
                    $sheet->loadView('dashboard.report.memberbaru.search_excel')->with('gyms',$gyms)
                                                                                ->with('currentdate',$currentdate)
                                                                                ->with('backdate',$backdate)
                                                                                ->with('tofifteen',$tofifteen);
            });
            })->download('xls');
        }else{
            return Excel::create('Report Member All', function($excel) use ($zonas,$backdate,$currentdate,$tofifteen){
                $excel->sheet('New sheet', function($sheet) use ($zonas,$backdate,$currentdate,$tofifteen){
                    $sheet->loadView('dashboard.report.memberbaru.zona_excel')->with('zonas',$zonas)
                                                                                ->with('currentdate',$currentdate)
                                                                                ->with('backdate',$backdate)
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

        if($id==null){
            if($request->get('lokasi') == 1){
                $gyms = gym::get();
            }else if($request->get('lokasi') == 3){
                $gyms = gym::whereIn('id',$tertentugym)->get();
            }else if($request->get('lokasi') == 5){
                $gyms = gym::whereIn('id',$tertentugymku)->get();
            }else if($request->get('lokasi') == 2){
                $zonas = Zona::get();
            }else{
                $zonas = Zona::whereIn('id',$tertentuzona)->get();
            }
        }else{
            $gyms = Gym::orderBy('title','ASC')->where('zona_id',$id)->get();  
        }

        if($request->lokasi == 1||$request->lokasi == 3||$request->lokasi == 5||$id!=null)
        {
            $pdf = PDF::loadView('dashboard.report.memberbaru.search_excel',compact('gyms','backdate','currentdate','tofifteen'));
            return $pdf->download('Report Member All.pdf');
        }else{
            $pdf = PDF::loadView('dashboard.report.memberbaru.zona_excel',compact('zonas','backdate','currentdate','tofifteen'));
            return $pdf->download('Report Member All.pdf');
        }
    }
}