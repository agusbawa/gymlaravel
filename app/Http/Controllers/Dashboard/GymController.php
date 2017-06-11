<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Gym;
use App\Member;
use App\Attendance;
use App\Zona;
use App\Package;
use App\Pettycash;
use Response;
use Auth;
use App\GymUser;
use View;
class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    protected $ownershipType = array(
        'sendiri' => "Sendiri",
        'franchise' => "Franchise"
    );
    
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('25',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $zonas = Zona::get();
        $zone = "";
        if(\App\Permission::CheckGym(Auth::user()->id)==1){
            View::share('keyword','');
            $gymuser = GymUser::where('user_id',Auth::user()->id);
            $gym = Gym::orderBy('title','asc');
              foreach($gymuser as $user){
                  $gym->where('id',$user);
              }
              $table = $gymuser->paginate(15);
             
            return view('dashboard.gym.index')->with('zonas',$zonas)->with('zone',$zone)->with('table',$table);
        }else{
        Gym::bootIndexPage($request->get('keyword'), ['title', 'address'],['title'=>'asc'],'members');
        return view('dashboard.gym.index')->with('zonas',$zonas)->with('zone',$zone);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zonas  =   Zona::get();
        $package = Package::get();
        return view('dashboard.gym.create')->with("zonas",$zonas)->with("package",$package)->with('ownerType',$this->ownershipType);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       \Validator::make($request->all(), [
            'title'     => 'required|max:100',
            'address'   => 'required',
            'latitude'  => 'required',
            'longitude' => 'required',
            'package' => 'required',
            'supervisor' => 'required',
            'telp' => 'required || numeric',
            'ownership' => 'required',
            'saldo'    => 'required || numeric'
        ])->setAttributeNames([
            'title'     => 'Nama Gym',
            'address'   => 'Alamat',
            'latitude'  => 'Peta',
            'longitude' => 'Peta',
            'package' => 'Paket Harga',
            'supervisor' => 'Supervisor',
            'telp' => 'Telp.',
            'ownership' => 'Ownership',
            'saldo'    => 'Saldo Awal Petty Cash'
        ])->validate();

        $gym                =   new Gym;
        $gym->title         =   $request->get('title');
        $gym->address       =   $request->get('address');
        $gym->location_latitude      =   $request->get('latitude');
        $gym->location_longitude     =   $request->get('longitude');
        $gym->zona_id     =   $request->get('zona');
        $gym->package_id     =   $request->get('package');
        $gym->supervisor     =   $request->get('supervisor');
        $gym->telp = $request->get('telp');
        $gym->ownership = $request->get('ownership');
        $gym->ipaymu_key = $request->get('ipaymu_key');
        $gym->saldo_awal = $request->get('saldo');
        
        $gym->save();
        $petty = new Pettycash;
        $petty->gym_id = $gym->id;
        $petty->total = $request->get('saldo');
        $petty->save();
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Gym']));
        return redirect('/u/gyms');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gym    =   Gym::findOrFail($id);
        $totalRegister    =   number_format($gym->members()->count());   
        $monthlyRegister      =    number_format($gym->members()->whereMonth('created_at','=',date("m"))->count()) ;
       
        return view('dashboard.gym.show')
        ->with('gym',$gym)
        ->with('monthlyRegister',$monthlyRegister)
        ->with('totalRegister',$totalRegister);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (\App\Permission::EditPer('25',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $gym    =   Gym::findOrFail($id);
        $zonas  =   Zona::get();
        $package = Package::get();
        return view('dashboard.gym.edit')->with('gym',$gym)->with("zonas",$zonas)->with("package",$package)->with('ownerType',$this->ownershipType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \Validator::make($request->all(), [
            'title'     => 'required|max:100',
            'address'   => 'required',
            'latitude'  => 'required',
            'longitude' => 'required',
            'package' => 'required',
            'supervisor' => 'required',
            'telp' => 'required || numeric',
            'ownership' => 'required',
            'saldo'    => 'required || numeric'
        ])->setAttributeNames([
            'title'     => 'Nama Gym',
            'address'   => 'Alamat',
            'latitude'  => 'Peta',
            'longitude' => 'Peta',
            'package' => 'Paket Harga',
            'supervisor' => 'Supervisor',
            'telp' => 'Telp.',
            'ownership' => 'Ownership',
            'saldo'    => 'Saldo Awal Petty Cash'
        ])->validate();

        $gym                =   Gym::findOrFail($id);
        $gym->title         =   $request->get('title');
        $gym->address       =   $request->get('address');
        $gym->location_latitude      =   $request->get('latitude');
        $gym->location_longitude     =   $request->get('longitude');
        $gym->zona_id     =   $request->get('zona');
        $gym->package_id     =   $request->get('package');
        $gym->supervisor     =   $request->get('supervisor');
        $gym->telp = $request->get('telp');
        $gym->ownership = $request->get('ownership');
        $gym->ipaymu_key = $request->get('ipaymu_key');
        $gym->saldo_awal = $request->get('saldo');
        $gym->save();
                $petty = new Pettycash;
            
        $petty->gym_id = $gym->id;
        $petty->total = $request->get('saldo');
        $petty->tanggal_petty = date('Y-m-d',strtotime($gym->updated_at));
        $petty->save();
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Gym']));

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Gym']));
        return redirect('/u/gyms');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('25',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $gym    =   Gym::findOrFail($id);

        if($gym->members()->count() > 0)
        {
            request()->session()->flash('alert-error', 'Gagal menghapus Gym dikarenakan terdapat '.$gym->members()->count().' member yang masuk terkait Gym ini.');
            return redirect('/u/gyms');
        }
        
        $gym->delete();

        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Gym']));
        return redirect('/u/gyms');
    }

    public function checkIn(Request $request, \App\Gym $gym)
    {
        $member =   Member::find($request->get('member_id'));
        if ($member==null) {
            $request->session()->flash('alert-error', 'Tidak dapat checkin ID tidak ditemukan');
            return redirect()->back();
        }

        $member->checkIn($gym->id);
        return redirect()->back();
    }

    public function checkOut(Request $request, \App\Gym $gym)
    {
        $member =   Member::find($request->get('member_id'));
        if ($member==null) {
            $request->session()->flash('alert-error', 'Tidak dapat checkin ID tidak ditemukan');
            return redirect()->back();
        }

        $member->checkOut($gym->id);
        return redirect()->back();
    }
    public function search(Request $request)
    {
        View::share('keyword',$request->get('keyword'));
        # code...
         if(\App\Permission::CheckGym(Auth::user()->id)==1){
             $zonas = Zona::orderBy('title','asc')->get();
            $gymuser = GymUser::where('user_id',Auth::user()->id);
           if($request->get('keyword')=="" && $request->get('kategori')!=""){
            $zone =$request->kategori;
            $table = $gymuser->paginate(15);
            }else if($request->get('keyword')!="" && $request->get('kategori')==""){
            $zone = "";
            $table = $gymuser->paginate(15);
            }else if($request->get('keyword')!="" && $request->get('kategori')!=""){
            $zone =$request->kategori;
            $table = $gymuser->paginate(15);
            }else{
            $zone = "";
            $table = $gymuser->paginate(15);    
            }
             
            return view('dashboard.gym.index')->with('zonas',$zonas)->with('zone',$zone)->with('table',$table);
        }else{
        if($request->get('keyword')=="" && $request->get('kategori')!=""){
            $zone =$request->kategori;
            $table = Gym::orderBy('title','asc')->where('zona_id',$request->kategori)->paginate(15);
        }else if($request->get('keyword')!="" && $request->get('kategori')==""){
            $zone = "";
        $table = Gym::orderBy('title','asc')->where('title','like','%'.$request->keyword.'%')->paginate(15);
        }else if($request->get('keyword')!="" && $request->get('kategori')!=""){
            $zone =$request->kategori;
            $table = Gym::orderBy('title','asc')->where('title','like','%'.$request->keyword.'%')->where('zona_id',$request->kategori)->paginate(15);
        }else{
            
        $zone = "";
        $table=Gym::orderBy('title','asc')->paginate(15);
        }
        $zonas = Zona::orderBy('title','asc')->get();
        return view('dashboard.gym.index')
        ->with('zonas',$zonas)
        ->with('table',$table)
        ->with('zone',$zone)
        
        ;
        }
    }
    public function getpaket($id)
    {
        $paket = Gym::findOrFail($id);
        $paketlist = \App\PackagePrice::where('package_id',$paket->package_id)->get();
        return response()->json(['paket'=>$paketlist->pluck('title','id')], 200);
    }
    public function getpaketharian($id)
    {
        $paket = Gym::findOrFail($id);
        $paketlist = \App\PackagePrice::where('package_id',$paket->package_id)->where('day','1')->get();
        return response()->json(['paket'=>$paketlist->pluck('title','id')], 200);
    }
}
