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
class newmemberyearvsController extends Controller
{
    public function view_newmemberyear(Request $request)
    {
        if($request->get('nama_gym')==0)
        {
            $nama_gym = $request->get('nama_gym');
            if($request->get('tahun_gym')==null){
                $tahun_gym = date("Y",strtotime(Carbon::parse(Carbon::now())));
            }else{
                $tahun_gym = $request->get('tahun_gym');
            }
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
            if($nama_gym==1){
                $title_gym = DB::table('gyms')->pluck('title');
            }elseif($nama_gym==2){
                $title_gym = DB::table('zonas')->pluck('id');
            }elseif($nama_gym==3){
                $title_gym = DB::table('gyms')->whereIn('id',$tertentugym)->pluck('title');
            }elseif($nama_gym==4){
                $title_gym = DB::table('zonas')->whereIn('id',$tertentuzona)->pluck('id');
            }else{
                $title_gym = DB::table('zonas')->pluck('id');
            }
            return view('dashboard.report.new.newmemberyearvs.jum_newmemberyear',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','tahun_gym','gyms','zonas','tertentugym','tertentuzona'));
        }else{
            $nama_gym = $request->get('nama_gym');
            $tahun_gym = $request->get('tahun_gym');
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
            return view('dashboard.report.new.newmemberyearvs.newmemberyear',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','tahun_gym','gyms','zonas','tertentugym','tertentuzona'));
        }
    }

    public function zona_newmemberyear(Request $request, $id)
    {
        $nama_gym = $request->get('nama_gym');
            $tahun_gym = $request->get('tahun_gym');
            $tertentugym = array();
            $tertentuzona = array();
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

            return view('dashboard.report.new.newmemberyearvs.zona_newmemberyear',compact('id','range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','tahun_gym','gyms','zonas','tertentugym','tertentuzona'));
    }

    public function exportExcel_newmemberyearvs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        if($request->get('tahun_gym')==null){
                $tahun_gym = date("Y",strtotime(Carbon::parse(Carbon::now())));
            }else{
                $tahun_gym = $request->get('tahun_gym');
            }
        return Excel::create('Report Member All', function($excel) use ($title_gym,$tahun_gym){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$tahun_gym){
                $sheet->loadView('dashboard.report.new.newmemberyearvs.member_excel')->with('title_gym',$title_gym)
                                                                                   ->with('tahun_gym',$tahun_gym);
            });
        })->download('xls');
    }

    public function exportPDF_newmemberyearvs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        if($request->get('tahun_gym')==null){
                $tahun_gym = date("Y",strtotime(Carbon::parse(Carbon::now())));
            }else{
                $tahun_gym = $request->get('tahun_gym');
            }
        $pdf = PDF::loadView('dashboard.report.new.newmemberyearvs.member_excel',compact('title_gym','tahun_gym'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function exportExcel_newmemberyearvs1(Request $request)
    {
        $nama_gym = $request->get('nama_gym');
        $id = $request->get('id');
            $tahun_gym = $request->get('tahun_gym');
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
            }elseif($id!=null){
                $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            }
        return Excel::create('Report Member All', function($excel) use ($id,$nama_gym,$title_gym,$tahun_gym){
            $excel->sheet('New sheet', function($sheet) use ($id,$nama_gym,$title_gym,$tahun_gym){
                $sheet->loadView('dashboard.report.new.newmemberyearvs.search_excel')->with('nama_gym',$nama_gym)
                                                                                   ->with('title_gym',$title_gym)
                                                                                   ->with('tahun_gym',$tahun_gym)
                                                                                   ->with('id',$id);
            });
        })->download('xls');
    }

    public function exportPDF_newmemberyearvs1(Request $request)
    {
        $nama_gym = $request->get('nama_gym');
        $id = $request->get('id');
            $tahun_gym = $request->get('tahun_gym');
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
            }elseif($id!=null){
                $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            }
        $pdf = PDF::loadView('dashboard.report.new.newmemberyearvs.search_excel',compact('nama_gym','title_gym','tahun_gym','id'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}
