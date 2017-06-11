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
class newextendsvsController extends Controller
{
    public function view_newmembervs(Request $request)
    {
        if($request->get('nama_gym')==0)
        {
            $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
            $kode_gym = DB::table('gyms')->pluck('id');
            $tertentugym = array();
            $tertentuzona = array();
            if($request->get('gyms')){
                $tertentugym = $request->get('gyms');
            }
            if($request->get('zonasku')){
                $tertentuzona = $request->get('zonasku');
            }
            $gyms = DB::table('gyms')->get();
            $zonas = DB::table('zonas')->get();
            // dd($request);
            
            $title_gym = DB::table('zonas')->pluck('id');
                    
            if($rangeku!==null){
                $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.newextendsvs.jum_newmembervs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona'));
            }else{
                $start_date = '';
                $end_date = '';
                $start_date_1 = '';
                $end_date_1 = '';
                $report_expired = '';
                $report_expired_1 = '';
                $report_extends = '';
                $report_extends_1 = '';
                $per_expired = '';
                $per_extends = '';
                $no = "";
                $no_1 = "";
                $id_gym = "";
                $kode_gym = "";
                return view('dashboard.report.new.newextendsvs.jum_newmembervs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','id_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona'));
            }       
        }else{
            $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
            $kode_gym = DB::table('gyms')->pluck('id');
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
            if($nama_gym==1){
                $title_gym = DB::table('gyms')->pluck('title');
            }elseif($nama_gym==2){
                $title_gym = DB::table('zonas')->pluck('id');
            }elseif($nama_gym==3){
                $title_gym = DB::table('gyms')->whereIn('id',$tertentugym)->pluck('title');
            }elseif($nama_gym==4){
                $title_gym = DB::table('zonas')->whereIn('id',$tertentuzona)->pluck('id');
            }elseif($nama_gym==5){
                $title_gym = DB::table('gyms')->whereIn('id',$tertentugymku)->pluck('title');
            }else{
                $title_gym = DB::table('zonas')->pluck('id');
            }
                    
            if($rangeku!==null){
                $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.newextendsvs.newmembervs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona'));
            }else{
                $start_date = '';
                $end_date = '';
                $start_date_1 = '';
                $end_date_1 = '';
                $report_expired = '';
                $report_expired_1 = '';
                $report_extends = '';
                $report_extends_1 = '';
                $per_expired = '';
                $per_extends = '';
                $no = "";
                $no_1 = "";
                $id_gym = "";
                $kode_gym = "";
                return view('dashboard.report.new.newextendsvs.newmembervs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','id_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona'));
            }       
        }
    }

    public function zona_newmembervs(Request $request, $id)
    {
        $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
            $kode_gym = DB::table('gyms')->pluck('id');
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

            $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
                    
            if($rangeku!==null){
                $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.newextendsvs.zona_newmembervs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona'));
            }else{
                $start_date = '';
                $end_date = '';
                $start_date_1 = '';
                $end_date_1 = '';
                $report_expired = '';
                $report_expired_1 = '';
                $report_extends = '';
                $report_extends_1 = '';
                $per_expired = '';
                $per_extends = '';
                $no = "";
                $no_1 = "";
                $id_gym = "";
                $kode_gym = "";
                return view('dashboard.report.new.newextendsvs.zona_newmembervs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','id_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona'));
            }  
    }

    public function exportExcel(Request $request)
    {
        $range = explode(" - ", $request->get('range'));
        $start_date = date("Y-m-1");
        $end_date = date("Y-m-d");

        $range_1 = explode(" - ", $request->get('range_1'));
        $start_date_1 = date("Y-m-1");
        $end_date_1 = date("Y-m-d");

        $nama_gym = $request->get('nama_gym');
        $rangeku = $request->get('range');
        $kode_gym = DB::table('gyms')->pluck('id');
        $tertentugym = array();
        $tertentuzona = array();
        if($request->get('gyms')){
            $tertentugym = $request->get('gyms');
        }
        if($request->get('zonasku')){
            $tertentuzona = $request->get('zonasku');
        }
        $gyms = DB::table('gyms')->get();
        $zonas = DB::table('zonas')->get();
        
            
        $title_gym = DB::table('zonas')->pluck('id');
        return Excel::create('Report Member All', function($excel) use ($title_gym,$range,$start_date,$end_date,$start_date_1,$end_date_1){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$range,$start_date,$end_date,$start_date_1,$end_date_1){
                $sheet->loadView('dashboard.report.new.newextendsvs.member_excel')->with('range',$range)
                                                                            ->with('start_date',$start_date)
                                                                            ->with('end_date',$end_date)
                                                                            ->with('start_date_1',$start_date_1)
                                                                            ->with('end_date_1',$end_date_1)
                                                                            ->with('title_gym',$title_gym);
            });
        })->download('xls');
    }

    public function exportPDF(Request $request)
    {
        $range = explode(" - ", $request->get('range'));
        $start_date = date("Y-m-1");
        $end_date = date("Y-m-d");

        $range_1 = explode(" - ", $request->get('range_1'));
        $start_date_1 = date("Y-m-1");
        $end_date_1 = date("Y-m-d");

        $nama_gym = $request->get('nama_gym');
        $rangeku = $request->get('range');
        $kode_gym = DB::table('gyms')->pluck('id');
        $tertentugym = array();
        $tertentuzona = array();
        if($request->get('gyms')){
            $tertentugym = $request->get('gyms');
        }
        if($request->get('zonasku')){
            $tertentuzona = $request->get('zonasku');
        }
        $gyms = DB::table('gyms')->get();
        $zonas = DB::table('zonas')->get();
        
            
        $title_gym = DB::table('zonas')->pluck('id');

        $pdf = PDF::loadView('dashboard.report.new.newextendsvs.member_excel',compact('title_gym','range','start_date','end_date','start_date_1','end_date_1'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function exportExcel1(Request $request)
    {
        $nama_gym = $request->get('nama_gym');
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
            if($nama_gym==1){
                $title_gym = DB::table('gyms')->pluck('title');
            }elseif($nama_gym==2){
                $title_gym = DB::table('zonas')->pluck('id');
            }elseif($nama_gym==3){
                $title_gym = DB::table('gyms')->whereIn('id',$tertentugym)->pluck('title');
            }elseif($nama_gym==4){
                $title_gym = DB::table('zonas')->whereIn('id',$tertentuzona)->pluck('id');
            }elseif($nama_gym==5){
                $title_gym = DB::table('gyms')->whereIn('id',$tertentugymku)->pluck('title');
            }elseif($id!=null){
                $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            }
        $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    
        return Excel::create('Report Member All', function($excel) use ($id,$title_gym,$range,$range_1,$start_date,$end_date,$start_date_1,$end_date_1,$nama_gym){
            $excel->sheet('New sheet', function($sheet) use ($id,$title_gym,$range,$range_1,$start_date,$end_date,$start_date_1,$end_date_1,$nama_gym){
                $sheet->loadView('dashboard.report.new.newextendsvs.search_excel')->with('range',$range)
                                                                            ->with('range_1',$range_1)
                                                                            ->with('start_date',$start_date)
                                                                            ->with('end_date',$end_date)
                                                                            ->with('start_date_1',$start_date_1)
                                                                            ->with('end_date_1',$end_date_1)
                                                                            ->with('title_gym',$title_gym)
                                                                            ->with('nama_gym',$nama_gym)
                                                                            ->with('id',$id);
            });
        })->download('xls');
    }

    public function exportPDF1(Request $request)
    {
        $nama_gym = $request->get('nama_gym');
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
            if($nama_gym==1){
                $title_gym = DB::table('gyms')->pluck('title');
            }elseif($nama_gym==2){
                $title_gym = DB::table('zonas')->pluck('id');
            }elseif($nama_gym==3){
                $title_gym = DB::table('gyms')->whereIn('id',$tertentugym)->pluck('title');
            }elseif($nama_gym==4){
                $title_gym = DB::table('zonas')->whereIn('id',$tertentuzona)->pluck('id');
            }elseif($nama_gym==5){
                $title_gym = DB::table('gyms')->whereIn('id',$tertentugymku)->pluck('title');
            }elseif($id!=null){
                $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            }
        $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    
        $pdf = PDF::loadView('dashboard.report.new.newextendsvs.search_excel',compact('title_gym','range','range_1','start_date','end_date','start_date_1','end_date_1','nama_gym','id'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}
