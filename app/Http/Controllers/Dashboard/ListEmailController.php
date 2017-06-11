<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Kantin;
use App\Gym;
use App\Member;
use App\Zona;
use App\PackagePrice;
use App\ListEmail;
use App\ZonaEmail;
use App\MemberListEmail;
use App\GymEmail;
use App\CheckinEmail;
use DB;
use View;
use Auth;
class ListEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        # code...
        if(\App\Permission::SubMenu('223',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $keyword = "";
        
        $table = ListEmail::orderBy('id','DESC')->paginate(15);
        if(!empty($request->get('keyword'))){
            $keyword = $request->get('keyword');
            $table = ListEmail::orderBy('id','DESC')->where('title','like','%'.$keyword.'%')->paginate(15);
        }
        View::share('keyword',$keyword);
        
        return view('dashboard.listemail.index')->with('table',$table);
    }
    public function search_index(Request $request)
    {
      $table = ListEmail::orderBy('id','DESC')
                ->where('title','like','%'.$request->keyword.'%')
                ->get();
      return view('dashboard.listemail.index')->with('table',$table);
    }
    public function create()
    {
        # code...
        $zona = Zona::get();
        $gym = Gym::get();
        $packagePrice = PackagePrice::get();
        $member = Member::orderBy('id','DESC')->paginate(15);
        return view('dashboard.listemail.create')
        ->with('member',$member)
        ->with('zona',$zona)
        ->with('gym',$gym)
        ->with('packageprice',$packagePrice)
        ;
    }
    public function store(Request $request)
    {
        \Validator::make($request->all(), [
            'title'     => 'required'
        ])->setAttributeNames([
            'title'     => 'Title'
        ])->validate();
        $list = new ListEmail;
       if(!empty($request->get('usiamin') || !empty($request->get('usiamax')))){
        \Validator::make($request->all(), [
            'usiamin'     => 'required',
            'usiamax'     => 'required'
        ])->setAttributeNames([
            'usiamin'     => 'Umur Minimal',
            'usiamin'     => 'Umur Maximal'
        ])->validate();
        $list->usia_min = $request->get('usiamin');
        $list->usia_max = $request->get('usiamax');
      
    }
    $list->member_baru_paket = $request->get('paket_baru');
    $list->perpanjang_baru_paket = $request->get('paket_perpanjang');
    $list->paket = $request->get('paket');
    if(!empty($request->get('expire'))){
        $list->expire = $request->get('expire');
    }
    if(!empty($request->get('harian'))){
        $list->gym_harian = "1";
    }
    if(!empty($request->get('trial'))){
        $list->free_tial = "1";
    }
    if(!empty($request->get('aktivasi'))){
        $list->member_belum_aktivais = "1";
    }
    if(!empty($request->get('expire'))){
        $list->expire = $request->get('expire');
    }
    if(!empty($request->get('month'))){
        $list->bulan = $request->get('month');
    }
    $list->title = $request->get('title');  
    $list->save();
    
if(!empty($request->get('zonas'))){
    foreach($request->get('zonas') as $zone){
       $zona = new ZonaEmail;
       $zona->list_email_id = $list->id;
       $zona->zona_id = $zone;
       $zona->save();
    }
}
    if(!empty($request->get('gyms'))){
         foreach($request->get('gyms') as $zone){
       $zona = new GymEmail;
       $zona->list_email_id = $list->id;
       $zona->gym_id = $zone;
       $zona->save();
         }
    }
    if(!empty($request->get('checks'))){
         foreach($request->get('checks') as $zone){
       $zona = new CheckinEmail;
       $zona->list_email_id = $list->id;
       $zona->attedances_id = $zone;
       $zona->save();
         }
    }
         $request->session()->flash('alert-success', 'List telah dibuat');
         return redirect('/u/listemail');
    }
    public function search(Request $request)
    {
        $zona = Zona::get();
        $gym = Gym::get();
        
         
        if($request->usia==null){
          $maxyear = 0;
        }else{
          $maxyear = date('Y')-$request->usia;
        }
        if(!empty($request->usia) && empty($request->zona) && empty($request->gym) && empty($request->keyword)){
            $member=Member::where('date_of_birth','>',$maxyear.'01-01')->get();
        }else if(empty($request->usia) && !empty($request->zona) && empty($request->gym) && empty($request->keyword)){
            $member=Member::orderBy('name','asc')
            ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
            ->get();
        }
        else if(empty($request->usia) && empty($request->zona) && !empty($request->gym) && empty($request->keyword)){
            $member=Member::orderBy('name','asc')
            ->where('gym_id','=',$request->gym)
            ->get();
        }
        else if(empty($request->usia) && empty($request->zona) && empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
            ->where('name','like','%'.$request->keyword.'%')
            ->get();
        }
        else if(!empty($request->usia) && !empty($request->zona) && empty($request->gym) && empty($request->keyword)){
            $member=Member::orderBy('name','asc')
            ->where('date_of_birth','>',$maxyear.'01-01')
             ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
            ->get();
        }
         else if(!empty($request->usia) && empty($request->zona) && !empty($request->gym) && empty($request->keyword)){
            $member=Member::orderBy('name','asc')
            ->where('date_of_birth','>',$maxyear.'01-01')
             ->where('gym_id','=',$request->gym)
            ->get();
        }
        else if(!empty($request->usia) && empty($request->zona) && empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
            ->where('date_of_birth','>',$maxyear.'01-01')
              ->where('name','like','%'.$request->keyword.'%')
            ->get();
        }
        else if(empty($request->usia) && !empty($request->zona) && !empty($request->gym) && empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
            ->where('gym_id','=',$request->gym)
            ->get();
        }
        else if(empty($request->usia) && !empty($request->zona) && empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
           ->where('name','like','%'.$request->keyword.'%')
            ->get();
        }
        else if(empty($request->usia) && empty($request->zona) && !empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->where('gym_id','=',$request->gym)
           ->where('date_of_birth','>',$maxyear.'01-01')
           
            ->get();
        }
        else if(!empty($request->usia) && !empty($request->zona) && !empty($request->gym) && empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->where('gym_id','=',$request->gym)
            ->where('date_of_birth','>',$maxyear.'01-01')
           ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
            ->get();
        }
        else if(!empty($request->usia) && empty($request->zona) && !empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->where('gym_id','=',$request->gym)
           ->where('name','like','%'.$request->keyword.'%')
           ->where('date_of_birth','>',$maxyear.'01-01')
            ->get();
        }
        
         else if(!empty($request->usia) && !empty($request->zona) && empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
           ->where('name','like','%'.$request->keyword.'%')
           ->where('date_of_birth','>',$maxyear.'01-01')
            ->get();
        }
        else if(empty($request->usia) && !empty($request->zona) && !empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
           ->where('name','like','%'.$request->keyword.'%')
           ->where('gym_id','=',$request->gym)
            ->get();
        }
         else if(!empty($request->usia) && !empty($request->zona) && !empty($request->gym) && !empty($request->keyword)){
            $member=Member::orderBy('name','asc')
             ->join('gyms','gyms.id','=','members.gym_id')
            ->where('gyms.zona_id','=',$request->zona)
           ->where('name','like','%'.$request->keyword.'%')
           ->where('gym_id','=',$request->gym)
            ->where('date_of_birth','>',$maxyear.'01-01')
            ->get();
        }
        else{
            //$member = Member::orderBy('id','DESC')->paginate(15);
            return redirect('/u/listemail/create');
        }
      
        
        
        return view('dashboard.listemail.create')
        ->with('member',$member)
        ->with('zona',$zona)
        ->with('gym',$gym)
        ;
    }
    public function edit($id)
    {
         if (\App\Permission::EditPer('223',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
      $listemail = ListEmail::findOrFail($id);
      $gymemail = GymEmail::where('list_email_id',$id)->get();
      $zonaemail = ZonaEmail::where('list_email_id',$id)->get();
      $checkemail = CheckinEmail::where('list_email_id',$id)->get();
      $zona = Zona::get();
        $gym = Gym::get();

        $packagePrice = PackagePrice::get();
        $member = Member::orderBy('id','DESC')->paginate(15);
      return view('dashboard.listemail.edit')->with('zona',$zona)
      ->with('listemail',$listemail)
         ->with('member',$member)
        ->with('zona',$zona)
        ->with('gymemail',$gymemail)
        ->with('checkemail',$checkemail)
        ->with('zonaemail',$zonaemail)
        ->with('gym',$gym)
        ->with('packageprice',$packagePrice);
    }
    public function update(Request $request, $id)
    {
      \Validator::make($request->all(), [
            'title'     => 'required'
        ])->setAttributeNames([
            'title'     => 'Title'
        ])->validate();
        $list = ListEmail::findOrFail($id);
       if(!empty($request->get('usiamin') || !empty($request->get('usiamax')))){
        \Validator::make($request->all(), [
            'usiamin'     => 'required',
            'usiamax'     => 'required'
        ])->setAttributeNames([
            'usiamin'     => 'Umur Minimal',
            'usiamin'     => 'Umur Maximal'
        ])->validate();
        $list->usia_min = $request->get('usiamin');
        $list->usia_max = $request->get('usiamax');
      
    }
    $list->member_baru_paket = $request->get('paket_baru');
    $list->perpanjang_baru_paket = $request->get('paket_perpanjang');
    $list->paket = $request->get('paket');
    if(!empty($request->get('expire'))){
        $list->expire = $request->get('expire');
    }
    if(!empty($request->get('harian'))){
        $list->gym_harian = "1";
    }
    if(!empty($request->get('trial'))){
        $list->free_tial = "1";
    }
    if(!empty($request->get('aktivasi'))){
        $list->member_belum_aktivais = "1";
    }
    if(!empty($request->get('expire'))){
        $list->expire = $request->get('expire');
    }
    if(!empty($request->get('month'))){
        $list->bulan = $request->get('month');
    }
    $list->title = $request->get('title');  
    $list->save();
    
if(!empty($request->get('zonas'))){
    foreach($request->get('zonas') as $zone){
       $zona = new ZonaEmail;
       $zona->list_email_id = $list->id;
       $zona->zona_id = $zone;
       $zona->save();
    }
}
    if(!empty($request->get('gyms'))){
         foreach($request->get('gyms') as $zone){
       $zona = new GymEmail;
       $zona->list_email_id = $list->id;
       $zona->gym_id = $zone;
       $zona->save();
         }
    }
    if(!empty($request->get('checks'))){
         foreach($request->get('checks') as $zone){
       $zona = new CheckinEmail;
       $zona->list_email_id = $list->id;
       $zona->attedances_id = $zone;
       $zona->save();
         }
    }
      $request->session()->flash('alert-success', 'List telah di update');
      return redirect('/u/listemail');
    }
    public function destroy(Request $request, $id)
    {
        if(\App\Permission::DeletePer('224',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
      $ListEmail = ListEmail::findOrFail($id);
      $gym = GymEmail::where('list_email_id',$id)->get();
      foreach($gym as $gy){
          $del = GymEmail::findOrFail($gy->id);
          $del->delete();
      }
      $zona = ZonaEmail::where('list_email_id',$id)->get();
      foreach($gym as $gy){
          $del = ZonaEmail::findOrFail($gy->id);
          $del->delete();
      }
      $checkin = CheckinEmail::where('list_email_id',$id)->get();
      foreach($gym as $gy){
          $del = CheckinEmail::findOrFail($gy->id);
          $del->delete();
      }
      $ListEmail->delete();
      $deleteMember = DB::table('member_list_email')->where('list_email_id', $id)->delete();
      $request->session()->flash('alert-success', 'List telah di hapus');
      return redirect('/u/listemail');
    }
   
}