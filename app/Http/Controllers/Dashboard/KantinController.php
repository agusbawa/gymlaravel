<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Kantin;
use App\Gym;
use App\GymUser;
use Auth;
use View;
class KantinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('11',Auth::user()->role_id) == 0){
            return redirect()->back();
        }
        $gyms    = Gym::orderBy('title','asc')->get();
        $selgym = "";
        $keyword = "";
        
        View::share('keyword', $keyword);
        if(empty($request->get('gym')) && !empty($request->get('keyword'))){
                if(\App\Permission::CheckGym(Auth::user()->id)==1){
                $keyword = $request->get('keyword');
                View::share('keyword', $keyword);
            
            $result = Kantin::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('name','like','%'.$keyword.'%')
                ->orWhere('tgl_bayar','like','%'.$keyword.'%')
               ;
            });
           $users = GymUser::where('user_id',Auth::user()->id)->get();
            foreach($users as $user){
                $result->orWhere('gym_id',$user->gym_id);
            }
            $table = $result->paginate(15)
            ;
                }else{
            $table = Kantin::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('name','like','%'.$keyword.'%')
                ->orWhere('tgl_bayar','like','%'.$keyword.'%')
               ;
            })
           
            ->paginate(15);
                }
            }else if(!empty($request->get('gym')) && empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $table = Kantin::orderBy('created_at','desc')
            ->where('gym_id',$request->gym)
            ->paginate(15);
               
            }
            else if(!empty($request->get('gym')) && !empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $keyword =$request->get('keyword');
                View::share('keyword', $keyword);
                 $table = Kantin::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('name','like','%'.$keyword.'%')
                ->orWhere('tgl_bayar','like','%'.$keyword.'%')
               ;
            })
            ->where('gym_id',$request->gym)
            ->paginate(15);
                
            }else{
                 if(\App\Permission::CheckGym(Auth::user()->id)==1){
                     $result = Kantin::orderBy('created_at','desc');
                      $users = GymUser::where('user_id',Auth::user()->id)->get();
                     foreach($users as $user){
                     $result->orWhere('gym_id',$user->gym_id);
                        }
                        $table = $result->paginate(15)
                    ;
                 }else{
               $table = Kantin::orderBy('created_at','desc')
            ->paginate(15);
                 }
            }
        return view('dashboard.kantin.index')->with('table',$table)->with('gyms',$gyms)->with('selgym',$selgym);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.kantin.create')->with('gyms',$gyms);
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
            'total'              =>'required || Numeric | min:1',
            'gym_id'             =>'required',
            'tgl_bayar'         =>'required',
            'metode'         =>'required',
            'keterangan'     =>''
        ])->setAttributeNames([
            'name'             =>'Nama',
            'total'              =>'Total',
            'gym_id'             =>'Gym',
            'tgl_bayar'         =>'Tanggal Bayar',
            'metode'         =>'Metode Pembayaran',
            'keterangan'         =>'Keterangan',
        ])->validate();

        $kantin                  =   new Kantin;
        $kantin->name           =   $request->get('name');
        $kantin->total            =   $request->get('total');
        $kantin->gym_id            =   $request->get('gym_id');
        
        $kantin->tgl_bayar          = date('Y-m-d',strtotime($request->get('tgl_bayar')))   ;
        $kantin->payment_method  = $request->get('metode');
        $kantin->keterangan      = $request->get('keterangan');
        $kantin->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Kantin']));
        return redirect('/u/kantin');
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
         if (\App\Permission::EditPer('11',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $kantin    = Kantin::findOrFail($id);
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
        return view('dashboard.kantin.edit')->with('kantin',$kantin)->with('gyms',$gyms);
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
            'total'              =>'required || Numeric | min:1',
            'gym_id'             =>'required',
            'tgl_bayar'         =>'required',
            'metode'         =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'total'              =>'Total',
            'gym_id'             =>'Gym',
            'tgl_bayar'         =>'Tanggal Bayar',
            'metode'         =>'Metode Pembayaran'
        ])->validate();

        $kantin                  = Kantin::findOrFail($id);
        $kantin->name           =   $request->get('name');
        $kantin->total            =   $request->get('total');
        $kantin->gym_id            =   $request->get('gym_id');
         $kantin->tgl_bayar          = date('Y-m-d',strtotime($request->get('tgl_bayar')))   ;
        $kantin->payment_method  = $request->get('metode'); 
        $kantin->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Kantin']));
        return redirect('/u/kantin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(\App\Permission::DeletePer('11',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $kantin    =   Kantin::findOrFail($id);
        $kantin->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Kantin']));
        return redirect('/u/kantin');
    }
}
