<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Memberharian;
use App\Gym;
use App\Package;
use App\PackagePrice;
use App\GymUser;
use Auth;
use View;
/*use Illuminate\Http\Response;
*/
use Response;
class GymsharianController extends Controller
{
    /**
     * Display a listing of the resource.
     
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(\App\Permission::SubMenu('9',Auth::user()->role_id) == 0){
            return redirect()->back();
      }   
        $gyms    = Gym::orderBy('title','asc')->get();
        $package = Package::orderBy('title','asc')->get();
        $keyword = "";
        View::share('keyword',$keyword);
        $selgym = "";
         if(empty($request->get('gym')) && !empty($request->get('keyword'))){
               
                $keyword = $request->get('keyword');
                View::share('keyword',$keyword);
        if(\App\Permission::CheckGym(Auth::user()->id)==1){
            $result = Memberharian::orderBy('created_at','desc')
            ->join('package_prices','package_prices.id','=','members_harian.package_id')
            ->join('gyms','gyms.id','=','members_harian.gym_id')
            
            ->orWhere('members_harian.name','like','%'.$keyword.'%')
            ->orWhere('members_harian.tgl_bayar','like','%'.$keyword.'%')
            ->orWhere('package_prices.title','like','%'.$keyword.'%')
            ->select('gyms.title as titlegym','package_prices.title as titlepackage','package_prices.price as price','members_harian.*');
            $users = GymUser::where('user_id',Auth::user()->id)->get();
            foreach($users as $user){
                $result->orWhere('members_harian.gym_id',$user->gym_id);
            }
            $table = $result->paginate(15)
            ;
        }else{
              $table = Memberharian::orderBy('created_at','desc')
            ->join('package_prices','package_prices.id','=','members_harian.package_id')
            ->join('gyms','gyms.id','=','members_harian.gym_id')
            
            ->orWhere('members_harian.name','like','%'.$keyword.'%')
            ->orWhere('members_harian.tgl_bayar','like','%'.$keyword.'%')
            ->orWhere('package_prices.title','like','%'.$keyword.'%')
            ->select('gyms.title as titlegym','package_prices.title as titlepackage','package_prices.price as price','members_harian.*')
           ->paginate(15)
            ;
        }
            }else if(!empty($request->get('gym')) && empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $table = Memberharian::orderBy('created_at','desc')
            ->join('package_prices','package_prices.id','=','members_harian.package_id')
            ->join('gyms','gyms.id','=','members_harian.gym_id')
            ->where('gyms.id',$request->gym)
             ->select('gyms.title as titlegym','package_prices.title as titlepackage','package_prices.price as price','members_harian.*')
            ->paginate(15);
               
            }
            else if(!empty($request->get('gym')) && !empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $keyword =$request->get('keyword');
                View::share('keyword',$keyword);
                 $table = Memberharian::orderBy('created_at','desc')
            ->join('package_prices','package_prices.id','=','members_harian.package_id')
            ->join('gyms','gyms.id','=','members_harian.gym_id')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('members_harian.name','like','%'.$keyword.'%')
                ->orWhere('members_harian.tgl_bayar','like','%'.$keyword.'%')
                ->orWhere('package_prices.title','like','%'.$keyword.'%');
            })
            ->where('gyms.id',$request->gym)
            ->select('gyms.title as titlegym','package_prices.title as titlepackage','package_prices.price as price','members_harian.*')
            ->paginate(15);
                
            }else{
                if(\App\Permission::CheckGym(Auth::user()->id)==1){
                $result = Memberharian::orderBy('created_at','desc')
                ->join('package_prices','package_prices.id','=','members_harian.package_id')
                ->join('gyms','gyms.id','=','members_harian.gym_id')
                ->select('gyms.title as titlegym','package_prices.title as titlepackage','package_prices.price as price','members_harian.*');
                $users = GymUser::where('user_id',Auth::user()->id)->get();
                foreach($users as $user){
                    $result->orWhere('members_harian.gym_id',$user->gym_id);
                }
                $table = $result->paginate(15)
                ;
                }else{
                    $table = Memberharian::orderBy('created_at','desc')
                ->join('package_prices','package_prices.id','=','members_harian.package_id')
                ->join('gyms','gyms.id','=','members_harian.gym_id')
                ->select('gyms.title as titlegym','package_prices.title as titlepackage','package_prices.price as price','members_harian.*')
               ->paginate(15)
                ;
                }
            }

        
           
            
        
        return view('dashboard.memberharian.index')->with('table',$table)->with('gyms',$gyms)->with('packages',$package)->with('selgym',$selgym);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       if(\App\Permission::CreatePer('9',Auth::user()->role_id) == 0){
           return redirect()->back();
       }
        $gyms    = Gym::orderBy('title','asc')->get();
        $package = PackagePrice::orderBy('title','asc')->get();
        return view('dashboard.memberharian.create')->with('gyms',$gyms)->with('packages',$package);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(),[
            'name'             =>'required',
            'nick_name'              =>'required',
            'gym_id'             =>'required',
            'package'              =>'required',
            'email'              =>'required',
            'telp'              =>'required',
            'metode'            =>'required',
            'keterangan'        =>'',
            'tgl_bayar'         =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'keterangan'      =>'Keterangan',
            'nick_name'              =>'Panggilan',
            'gym_id'             =>'Gym',
            'package'              =>'Paket',
            'email'              =>'Email',
            'telp'              =>'Telp',
            'metode'            =>'Metode Pembayaran',
            'tgl_bayar'         =>'Tanggal Bayar'

        ])->validate();

        $harian                  =   new Memberharian;
        $harian->name           =   $request->get('name');
        $harian->nick_name            =   $request->get('nick_name');
        $harian->gym_id            =   $request->get('gym_id');
        $harian->package_id            =   $request->get('package');
        $harian->email            =   $request->get('email');
        $harian->telp            =   $request->get('telp');
        $harian->payment_method            =   $request->get('metode');
        $harian->keterangan            = $request->get('keterangan');
        $harian->tgl_bayar            =   date('Y-m-d',strtotime($request->get('tgl_bayar')));
        $harian->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Member Harian']));
        return redirect('/u/gymharian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax() && $request->get('action')=="VALIDATE"){
            $promo = Promo::isValid($request->get('code'));
            if (is_null($promo)) {
                return response()->json(['status'=>false]);
            }
            return response()->json(['status'=>true]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       if (\App\Permission::EditPer('9',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $harian    = Memberharian::findOrFail($id);
       if(\App\Permission::CheckGym(Auth::user()->id)==1){
           $result =  Gym::orderBy('title','asc');
             $users = GymUser::where('user_id',Auth::user()->id)->get();
           foreach($users as $user){
                     $result->orWhere('id',$user->gym_id);
                        }
                        $gyms = $result->get()
                    ;
        }else{
        $gyms    = Gym::orderBy('title','asc')->get();
        }
        $package = PackagePrice::orderBy('title','asc')->where('day','1')->get();
        return view('dashboard.memberharian.edit')->with('harian',$harian)->with('gyms',$gyms)->with('packages',$package);
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
        \Validator::make($request->all(),[
            'name'             =>'required',
            'nick_name'              =>'required',
            'gym_id'             =>'required',
            'package'              =>'required',
            'email'              =>'required',
            'telp'              =>'required',
            'metode'            =>'required',
            'keterangan'           =>'',
            'tgl_bayar'         =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'nick_name'              =>'Panggilan',
            'gym_id'             =>'Gym',
            'package'              =>'Paket',
            'email'              =>'Email',
            'telp'              =>'Telp',
            'metode'            =>'Metode Pembayaran',
            'keterangan'        =>'Keterangan',
            'tgl_bayar'         =>'Tanggal Bayar'
        ])->validate();

        $harian                  = Memberharian::findOrFail($id);
        $harian->name           =   $request->get('name');
        $harian->nick_name            =   $request->get('nick_name');
        $harian->gym_id            =   $request->get('gym_id');
        $harian->package_id            =   $request->get('package');
        $harian->email            =   $request->get('email');
        $harian->payment_method            =   $request->get('metode');
        $harian->tgl_bayar            =   date('Y-m-d',strtotime($request->get('tgl_bayar')));
        $harian->telp            =   $request->get('telp');
        $harian->keterangan         = $request->get('keterangan');
        $harian->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Member Harian']));
        return redirect('/u/gymharian');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('9',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $harian    =   Memberharian::findOrFail($id);
        $harian->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Member Harian']));
        return redirect('/u/gymharian');
    }
    public function lookprice($id){
        $price=PackagePrice::find($id);
        return Response::json($price,200);
    }
}
