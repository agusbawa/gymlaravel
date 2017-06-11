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
class RegisterMemberController extends Controller
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
        $gyms = DB::table('gyms')->get();
        $zonas = DB::table('zonas')->get();
        $currentdate = Carbon::now()->toDateTimeString();
        $backdate = Carbon::parse('-30 days')->toDateTimeString();
        $date30DaysBack = Carbon::parse($backdate)->format('Y-m-d');
        $tofifteen = Carbon::parse('15 days')->toDateTimeString();
        return view('dashboard.report.registrasimember.member',compact('nama_gym','gyms','zonas','tertentugym','tertentuzona'))
        ->with('currentdate',$currentdate)
        ->with('backdate',$backdate)
        ->with('tofiftieen',$tofifteen)
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
       
        if($request->get('lokasi') == 1||$request->get('lokasi') == 3||$request->get('lokasi') == 5){
            if($request->get('lokasi') == 1){
                $gyms = gym::get();
            }else if($request->get('lokasi') == 3){
                $gyms = gym::whereIn('id',$tertentugym)->get();
            }else if($request->get('lokasi') == 5){
                 $gyms = gym::whereIn('id',$tertentugymku)->get();
            }
            return view('dashboard.report.registrasimember.searchmember',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
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
            return view('dashboard.report.registrasimember.zonamember',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('zonas',$zonas)
            ;
        }
    }
    
    public function link_zonaregistrasi(Request $request, $id)
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
            return view('dashboard.report.registrasimember.link_zonaregistrasi',compact('nama_gym','gym','zona','tertentugym','tertentuzona'))
            ->with('currentdate',$currentdate)
            ->with('backdate',$backdate)
            ->with('tofiftieen',$tofifteen)
            ->with('gyms',$gyms)
        ;
    }
}