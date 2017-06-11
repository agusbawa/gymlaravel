<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pengeluaran;
use App\Gym;
use View;
use App\GymUser;
use Auth;
class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('12',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $gyms    = Gym::orderBy('title','asc')->get();
        $selgym = "";
        $keyword = "";
        View::share('keyword', $keyword);
        if(empty($request->get('gym')) && !empty($request->get('keyword'))){
               
                $keyword = $request->get('keyword');
                View::share('keyword', $keyword);
            if(\App\Permission::CheckGym(Auth::user()->id)==1){
            $result = Pengeluaran::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('name','like','%'.$keyword.'%')
                ->orWhere('tgl_keluar','like','%'.$keyword.'%')
               ;
            });
           $users = GymUser::where('user_id',Auth::user()->id)->get();
           foreach($users as $user){
                     $result->orWhere('gym_id',$user->gym_id);
                        }
                        $table = $result->paginate(15)
                    ;
            }else{
             $table = Pengeluaran::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('name','like','%'.$keyword.'%')
                ->orWhere('tgl_keluar','like','%'.$keyword.'%')
               ;
            })
           
            ->paginate(15);
            }
            }else if(!empty($request->get('gym')) && empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $table = Pengeluaran::orderBy('created_at','desc')
            ->where('gym_id',$request->gym)
            ->paginate(15);
               
            }
            else if(!empty($request->get('gym')) && !empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $keyword =$request->get('keyword');
                View::share('keyword', $keyword);
                 $table = Pengeluaran::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('name','like','%'.$keyword.'%')
                ->orWhere('tgl_keluar','like','%'.$keyword.'%')
               ;
            })
            ->where('gym_id',$request->gym)
            ->paginate(15);
                
            }else{
                 if(\App\Permission::CheckGym(Auth::user()->id)==1){
               $result = Pengeluaran::orderBy('created_at','desc');
                $users = GymUser::where('user_id',Auth::user()->id)->get();
           foreach($users as $user){
                     $result->orWhere('gym_id',$user->gym_id);
                        }
                        $table = $result->paginate(15)
                    ;
                 }else{
                $table = Pengeluaran::orderBy('created_at','desc')
                 
            ->paginate(15);
                 }
            }
            
        
        return view('dashboard.pengeluaran.index')->with('table',$table)->with('selgym',$selgym)->with('gyms',$gyms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.pengeluaran.create')->with('gyms',$gyms);
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
            'total'              =>'required || Numeric',
            'gym_id'             =>'required',
            'deskripsi'          =>'required',
            'tgl_keluar'         =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'total'              =>'Fee Trainer',
            'gym_id'             =>'Gym',
            'deskripsi'          =>'Deskripsi',
            'tgl_keluar'         =>'Tanggal Keluar'
        ])->validate();
        $tglStoran = explode('-', $request->get('tgl_keluar'));
        $pengeluaran                  =   new Pengeluaran;
        $pengeluaran->name           =   $request->get('name');
        $pengeluaran->total            =   $request->get('total');
        $pengeluaran->gym_id            =   $request->get('gym_id');
        $pengeluaran->tgl_keluar        =$tglStoran[2].'-'.$tglStoran[1].'-'.$tglStoran[0].' 00:00:00';
        $pengeluaran->deskripsi         = $request->get('deskripsi');
        $pengeluaran->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Pengeluaran']));
        return redirect('/u/pengeluaran');
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
         if (\App\Permission::EditPer('12',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $pengeluaran    = Pengeluaran::findOrFail($id);
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
        return view('dashboard.pengeluaran.edit')->with('pengeluaran',$pengeluaran)->with('gyms',$gyms);
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
            'total'              =>'required || Numeric',
            'gym_id'             =>'required',
            'deskripsi'          =>'required',
            'tgl_keluar'         =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'total'              =>'Fee Trainer',
            'gym_id'             =>'Gym',
            'deskripsi'          =>'Deskripsi',
            'tgl_keluar'         =>'Tanggal Keluar'
 ])->validate();
 $tglStoran = explode('-', $request->get('tgl_keluar'));
        $pengeluaran                  = Pengeluaran::findOrFail($id);
        $pengeluaran->name           =   $request->get('name');
        $pengeluaran->total            =   $request->get('total');
        $pengeluaran->gym_id            =   $request->get('gym_id');
         $pengeluaran->tgl_keluar        =$tglStoran[2].'-'.$tglStoran[1].'-'.$tglStoran[0].' 00:00:00';
        $pengeluaran->deskripsi         = $request->get('deskripsi');
        $pengeluaran->save();
        $pengeluaran->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Pengeluaran']));
        return redirect('/u/pengeluaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(\App\Permission::DeletePer('12',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $pengeluaran    =   Pengeluaran::findOrFail($id);
        $pengeluaran->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Pengeluaran']));
        return redirect('/u/pengeluaran');
    }
}
