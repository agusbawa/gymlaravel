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
class ReportAllController extends Controller
{
    public function view_extendvs(Request $request){
        if($request->get('nama_gym')==0){
            $title_gym = DB::table('zonas')->pluck('id');
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
            return view('dashboard.report.new.extendvs.jum_extendvs',compact('title_gym','gyms','zonas','tertentugym','tertentuzona'));
        }else{
            $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
            $title_gymku = DB::table('gyms')->get(); 
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
                    

                return view('dashboard.report.new.extendvs.extendvs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','title_gymku','gyms','zonas','tertentugym','tertentuzona'));
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
                return view('dashboard.report.new.extendvs.extendvs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','title_gymku','gyms','zonas','tertentugym','tertentuzona'));
            }      
        } 
    }

    public function zona_extendvs(Request $request, $id)
    {
        $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
            $title_gymku = DB::table('gyms')->get(); 
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
            $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            
         
                $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.extendvs.zona_extendvs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','title_gymku','gyms','zonas','tertentugym','tertentuzona'));
            
    }

    public function exportExcel_extendvs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        return Excel::create('Report Member All', function($excel) use ($title_gym){
            $excel->sheet('New sheet', function($sheet) use ($title_gym){
                $sheet->loadView('dashboard.report.new.extendvs.member_excel')->with('title_gym',$title_gym);
            });
        })->download('xls');
    }

    public function exportPDF_extendvs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');

        $pdf = PDF::loadView('dashboard.report.new.extendvs.member_excel',compact('title_gym'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function view_longpacket(Request $request){
        if($request->get('nama_gym')==0)
        {
            $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
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

                return view('dashboard.report.new.long_packet.jum_long_packet',compact('range','range_1','title_gym','gym_id','start_date','end_date','start_date_1','end_date_1','nama_gym','gyms','zonas','tertentugym','tertentuzona'));      
        }else{
            $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
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
                    

                return view('dashboard.report.new.long_packet.long_packet',compact('range','range_1','title_gym','gym_id','start_date','end_date','start_date_1','end_date_1','nama_gym','gyms','zonas','tertentugym','tertentuzona'));
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
                return view('dashboard.report.new.long_packet.long_packet',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','gyms','zonas','tertentugym','tertentuzona'));
            }
        }
    }

    public function zona_longpacket(Request $request, $id)
    {
        $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
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
            
            $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            
                $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.long_packet.zona_long_packet',compact('range','range_1','title_gym','gym_id','start_date','end_date','start_date_1','end_date_1','nama_gym','gyms','zonas','tertentugym','tertentuzona'));
    }

     public function exportExcel_longpacket(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        return Excel::create('Report Member All', function($excel) use ($title_gym){
            $excel->sheet('New sheet', function($sheet) use ($title_gym){
                $sheet->loadView('dashboard.report.new.long_packet.member_excel')->with('title_gym',$title_gym);
            });
        })->download('xls');
    }

    public function exportPDF_longpacket(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');

        $pdf = PDF::loadView('dashboard.report.new.long_packet.member_excel',compact('title_gym'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function view_promovs(Request $request)
    {
        if($request->get('nama_gym')==0){
            $title_promo = $request->get('title_promo');
            $nama_gym = $request->get('nama_gym');
            $promoku = DB::table('promos')->pluck('id');
            $id_ku = DB::table('promos')->where('title',$title_promo)->value('id');
            $promo = DB::table('promos')->where('id','like','%'.$id_ku.'%')->pluck('id');
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
            
            $id_promo = DB::table('promos')->where('title',$title_promo)->value('id');
            $id_news = DB::table('member_histories')->whereNull('new_register')->value('id');
            $id_exs = DB::table('member_histories')->whereNotNull('extends')->value('id');

            return view('dashboard.report.new.promovs.jum_promovs',compact('promo','promoku','title_gym','id_news','id_exs','nama_gym','title_promo','gyms','zonas','tertentugym','tertentuzona'));
        }else{
            $get_promo = $request->get('title_promo');
            $nama_gym = $request->get('nama_gym');
            $promoku = DB::table('promos')->pluck('id');
            $id_ku = DB::table('promos')->where('title',$get_promo)->value('id');
            $promo = DB::table('promos')->where('id','like','%'.$id_ku.'%')->pluck('id');
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
            
            $id_promo = DB::table('promos')->where('title',$get_promo)->value('id');
            $id_news = DB::table('member_histories')->whereNull('new_register')->value('id');
            $id_exs = DB::table('member_histories')->whereNotNull('extends')->value('id');

            return view('dashboard.report.new.promovs.promovs',compact('promo','promoku','title_gym','id_news','id_exs','nama_gym','get_promo','gyms','zonas','tertentugym','tertentuzona'));
        }
    }

    public function zona_promovs(Request $request, $id)
    {
        $title_promo = $request->get('title_promo');
            $nama_gym = $request->get('nama_gym');
            $promoku = DB::table('promos')->pluck('id');
            $id_ku = DB::table('promos')->where('title',$title_promo)->value('id');
            $promo = DB::table('promos')->where('id','like','%'.$id_ku.'%')->pluck('id');
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
          
            $title_gym = DB::table('gyms')->where('zona_id',$id)->pluck('title');
            
            $id_promo = DB::table('promos')->where('title',$title_promo)->value('id');
            $id_news = DB::table('member_histories')->whereNull('new_register')->value('id');
            $id_exs = DB::table('member_histories')->whereNotNull('extends')->value('id');

            return view('dashboard.report.new.promovs.zona_promovs',compact('promo','promoku','title_gym','id_news','id_exs','nama_gym','title_promo','gyms','zonas','tertentugym','tertentuzona'));
    }

    public function exportExcel_promovs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $id_ku = DB::table('promos')->value('id');
        $promo = DB::table('promos')->where('id','like','%'.$id_ku.'%')->pluck('id');
        return Excel::create('Report Member All', function($excel) use ($title_gym,$promo){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$promo){
                $sheet->loadView('dashboard.report.new.promovs.member_excel')->with('title_gym',$title_gym)
                                                                             ->with('promo',$promo);
            });
        })->download('xls');
    }

    public function exportPDF_promovs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $id_ku = DB::table('promos')->value('id');
        $promo = DB::table('promos')->where('id','like','%'.$id_ku.'%')->pluck('id');
        $pdf = PDF::loadView('dashboard.report.new.promovs.member_excel',compact('title_gym','promo'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

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
                    

                return view('dashboard.report.new.newmembervs.jum_newmembervs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona','tertentugymku'));
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
                return view('dashboard.report.new.newmembervs.jum_newmembervs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','id_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona','tertentugymku'));
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
                    

                return view('dashboard.report.new.newmembervs.newmembervs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona','tertentugymku'));
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
                return view('dashboard.report.new.newmembervs.newmembervs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','id_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona','tertentugymku'));
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
                    

                return view('dashboard.report.new.newmembervs.zona_newmembervs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona','id'));
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
                return view('dashboard.report.new.newmembervs.zona_newmembervs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','id_gym','kode_gym','gyms','zonas','tertentugym','tertentuzona','id'));
            }  
    }

    public function exportExcel_newmembervs(Request $request)
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
                $sheet->loadView('dashboard.report.new.newmembervs.member_excel')->with('range',$range)
                                                                            ->with('start_date',$start_date)
                                                                            ->with('end_date',$end_date)
                                                                            ->with('start_date_1',$start_date_1)
                                                                            ->with('end_date_1',$end_date_1)
                                                                            ->with('title_gym',$title_gym);
            });
        })->download('xls');
    }

    public function exportPDF_newmembervs(Request $request)
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

        $pdf = PDF::loadView('dashboard.report.new.newmembervs.member_excel',compact('title_gym','range','start_date','end_date','start_date_1','end_date_1'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function exportExcel_newmembervs1(Request $request)
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
                $sheet->loadView('dashboard.report.new.newmembervs.search_excel')->with('range',$range)
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

    public function exportPDF_newmembervs1(Request $request)
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
                    
        $pdf = PDF::loadView('dashboard.report.new.newmembervs.search_excel',compact('title_gym','range','range_1','start_date','end_date','start_date_1','end_date_1','nama_gym','id'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

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
            return view('dashboard.report.new.newmemberyear.jum_newmemberyear',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','tahun_gym','gyms','zonas','tertentugym','tertentuzona','tertentugymku'));
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
            return view('dashboard.report.new.newmemberyear.newmemberyear',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','tahun_gym','gyms','zonas','tertentugym','tertentuzona','tertentugymku'));
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

            return view('dashboard.report.new.newmemberyear.zona_newmemberyear',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','tahun_gym','gyms','zonas','tertentugym','tertentuzona','id'));
    }

    public function exportExcel_newmemberyear(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        if($request->get('tahun_gym')==null){
                $tahun_gym = date("Y",strtotime(Carbon::parse(Carbon::now())));
            }else{
                $tahun_gym = $request->get('tahun_gym');
            }
        return Excel::create('Report Member All', function($excel) use ($title_gym,$tahun_gym){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$tahun_gym){
                $sheet->loadView('dashboard.report.new.newmemberyear.member_excel')->with('title_gym',$title_gym)
                                                                                   ->with('tahun_gym',$tahun_gym);
            });
        })->download('xls');
    }

    public function exportPDF_newmemberyear(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        if($request->get('tahun_gym')==null){
                $tahun_gym = date("Y",strtotime(Carbon::parse(Carbon::now())));
            }else{
                $tahun_gym = $request->get('tahun_gym');
            }
        $pdf = PDF::loadView('dashboard.report.new.newmemberyear.member_excel',compact('title_gym','tahun_gym'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function exportExcel_newmemberyear1(Request $request)
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
                $sheet->loadView('dashboard.report.new.newmemberyear.search_excel')->with('nama_gym',$nama_gym)
                                                                                   ->with('title_gym',$title_gym)
                                                                                   ->with('tahun_gym',$tahun_gym)
                                                                                   ->with('id',$id);
            });
        })->download('xls');
    }

    public function exportPDF_newmemberyear1(Request $request)
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
        $pdf = PDF::loadView('dashboard.report.new.newmemberyear.search_excel',compact('nama_gym','title_gym','tahun_gym','id'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function view_extendlongvs(Request $request)
    {
        if($request->get('nama_gym')==0)
        {
            $nama_gym = $request->get('nama_gym');
            $rangeku = $request->get('range');
            if($request->get('pilih_kat')==null)
            {
                $pilih_kat = 'Expired';
            }else{
                $pilih_kat = $request->get('pilih_kat');
            }
            $tertentugym = array();
            $tertentuzona = array();
            if($request->get('gyms')){
                $tertentugym = $request->get('gyms');
            }
            if($request->get('zonas')){
                $tertentuzona = $request->get('zonas');
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
                    
            if($rangeku!==null){
                $range = explode(" - ", $request->get('range'));
                $start_date = date("Y-m-d", strtotime($range[0]));
                $end_date = date("Y-m-d", strtotime($range[1]));

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.extendlongvs.jum_extendlongvs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
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
                return view('dashboard.report.new.extendlongvs.jum_extendlongvs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            } 
        }else{
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
                    

                return view('dashboard.report.new.extendlongvs.extendlongvs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
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
                return view('dashboard.report.new.extendlongvs.extendlongvs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            } 
        }      
    }

    public function zona_extendlongvs(Request $request, $id)
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

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.extendlongvs.zona_extendlongvs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
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
                return view('dashboard.report.new.extendlongvs.zona_extendlongvs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            }
    }

    public function exportExcel_extendlongvs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $start_date = '';
        $end_date = '';
        return Excel::create('Report Member All', function($excel) use ($title_gym,$start_date,$end_date){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$start_date,$end_date){
                $sheet->loadView('dashboard.report.new.extendlongvs.member_excel')->with('title_gym',$title_gym)
                                                                            ->with('start_date',$start_date)
                                                                            ->with('end_date',$end_date);
            });
        })->download('xls');
    }

    public function exportPDF_extendlongvs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $start_date = '';
        $end_date = '';

        $pdf = PDF::loadView('dashboard.report.new.extendlongvs.member_excel',compact('title_gym','start_date','end_date'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
    

    public function view_incomevs(Request $request)
    {
        if($request->get('nama_gym')==0)
        {
            if($request->get('pilih_kat')==0)
            {
                $nama_gym = $request->get('nama_gym');
                $rangeku = $request->get('range');
                $pilih_kat = 'Baru';
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
                    return view('dashboard.report.new.incomevs.jum_incomevs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            }else{
                $nama_gym = $request->get('nama_gym');
                $rangeku = $request->get('range');
                $pilih_kat = $request->get('pilih_kat');
                $tertentugym = array();
                $tertentuzona = array();
                if($request->get('gyms')){
                    $tertentugym = $request->get('gyms');
                }
                if($request->get('zonas')){
                    $tertentuzona = $request->get('zonas');
                }
                $gyms = DB::table('gyms')->get();
                $zonas = DB::table('zonas')->get();
                // dd($request);
                
                    $title_gym = DB::table('zonas')->pluck('id');
                
                
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
                    return view('dashboard.report.new.incomevs.jum_incomevs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            }
        }else{    
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
                    

                return view('dashboard.report.new.incomevs.incomevs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
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
                return view('dashboard.report.new.incomevs.incomevs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            }   
        }    
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

                $range_1 = explode(" - ", $request->get('range_1'));
                $start_date_1 = date("Y-m-d", strtotime($range_1[0]));
                $end_date_1 = date("Y-m-d", strtotime($range_1[1]));
                    

                return view('dashboard.report.new.incomevs.zona_incomevs',compact('range','range_1','title_gym','start_date','end_date','start_date_1','end_date_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
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
                return view('dashboard.report.new.incomevs.zona_incomevs',compact('report_expired', 'report_expired_1','report_extends','report_extends_1','title_gym','start_date','end_date','start_date_1','end_date_1','per_expired','per_extends','no','no_1','nama_gym','pilih_kat','gyms','zonas','tertentugym','tertentuzona'));
            }   
    }

    public function exportExcel_incomevs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $start_date = '';
        $end_date = '';
        return Excel::create('Report Member All', function($excel) use ($title_gym,$start_date,$end_date){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$start_date,$end_date){
                $sheet->loadView('dashboard.report.new.incomevs.member_excel')->with('title_gym',$title_gym)
                                                                            ->with('start_date',$start_date)
                                                                            ->with('end_date',$end_date);
            });
        })->download('xls');
    }

    public function exportPDF_incomevs(Request $request)
    {
        $title_gym = DB::table('zonas')->pluck('id');
        $start_date = '';
        $end_date = '';

        $pdf = PDF::loadView('dashboard.report.new.incomevs.member_excel',compact('title_gym','start_date','end_date'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }

    public function view_incomeday(Request $request)
    {
        $title_gym = DB::table('gyms')->pluck('title');
        $mharian_id = DB::table('members_harian')->pluck('id');
        $id_trans = DB::table('transactions')->pluck('id');
        $id_personal = DB::table('personal_trainer')->pluck('id');
        $id_kantin = DB::table('kantin')->pluck('id');
        $id_pengeluaran = DB::table('pengeluaran')->pluck('id');
        $id_histori = DB::table('member_histories')->pluck('id');
        $id_petty_cash = DB::table('petty_cash')->pluck('id');
        $id_promo = DB::table('promos')->pluck('id');
        $nama_gym = $request->get('nama_gym');
        $date = date('Y-m-d',strtotime($request->get('range')));
        $dat = date('Y-m',strtotime($request->get('range')));
        $year = date('Y',strtotime($request->get('range')));
        return view('dashboard.report.new.incomeday',compact('title_gym','nama_gym','mharian_id','date','id_trans','id_personal','id_kantin','id_pengeluaran','dat','id_histori','year','id_petty_cash','id_promo'));
    }

    public function exportExcel_incomeday(Request $request)
    {
        $title_gym = DB::table('gyms')->pluck('title');
        $mharian_id = DB::table('members_harian')->pluck('id');
        $id_trans = DB::table('transactions')->pluck('id');
        $id_personal = DB::table('personal_trainer')->pluck('id');
        $id_kantin = DB::table('kantin')->pluck('id');
        $id_pengeluaran = DB::table('pengeluaran')->pluck('id');
        $id_histori = DB::table('member_histories')->pluck('id');
        $id_petty_cash = DB::table('petty_cash')->pluck('id');
        $id_promo = DB::table('promos')->pluck('id');
        $nama_gym = $request->get('nama_gym');
        $date = date('Y-m-d',strtotime($request->get('range')));
        $dat = date('Y-m',strtotime($request->get('range')));
        $year = date('Y',strtotime($request->get('range')));
        return Excel::create('Report Member All', function($excel) use ($title_gym,$mharian_id,$id_trans,$id_personal,$id_kantin,$id_pengeluaran,$id_histori,$id_petty_cash,$id_promo,$nama_gym,$date,$dat,$year){
            $excel->sheet('New sheet', function($sheet) use ($title_gym,$mharian_id,$id_trans,$id_personal,$id_kantin,$id_pengeluaran,$id_histori,$id_petty_cash,$id_promo,$nama_gym,$date,$dat,$year){
                $sheet->loadView('dashboard.report.new.member_excel')->with('title_gym',$title_gym)
                                                                            ->with('mharian_id',$mharian_id)
                                                                            ->with('id_trans',$id_trans)
                                                                            ->with('id_personal',$id_personal)
                                                                            ->with('id_kantin',$id_kantin)
                                                                            ->with('id_pengeluaran',$id_pengeluaran)
                                                                            ->with('id_histori',$id_histori)
                                                                            ->with('id_petty_cash',$id_petty_cash)
                                                                            ->with('id_promo',$id_promo)
                                                                            ->with('nama_gym',$nama_gym)
                                                                            ->with('date',$date)
                                                                            ->with('dat',$dat)
                                                                            ->with('year',$year);
            });
        })->download('xls');
    }

    public function exportPDF_incomeday(Request $request)
    {
        $title_gym = DB::table('gyms')->pluck('title');
        $mharian_id = DB::table('members_harian')->pluck('id');
        $id_trans = DB::table('transactions')->pluck('id');
        $id_personal = DB::table('personal_trainer')->pluck('id');
        $id_kantin = DB::table('kantin')->pluck('id');
        $id_pengeluaran = DB::table('pengeluaran')->pluck('id');
        $id_histori = DB::table('member_histories')->pluck('id');
        $id_petty_cash = DB::table('petty_cash')->pluck('id');
        $id_promo = DB::table('promos')->pluck('id');
        $nama_gym = $request->get('nama_gym');
        $date = date('Y-m-d',strtotime($request->get('range')));
        $dat = date('Y-m',strtotime($request->get('range')));
        $year = date('Y',strtotime($request->get('range')));

        $pdf = PDF::loadView('dashboard.report.new.member_excel',compact('title_gym','mharian_id','id_trans','id_personal','id_kantin','id_pengeluaran','id_histori','id_petty_cash','id_promo','nama_gym','date','dat','year'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Report Member All.pdf');
    }
}