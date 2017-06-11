<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Setoranbank;
use App\Gym;
use App\GymUser;
use Auth;
use App\Permission;
use View;
class StoranController extends Controller
{
    public $gym;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        
       //dd(Auth::user()->role_id); 
       // dd(Permission::SubMenu('13',Auth::user()->role_id));
        //
    }
    public function index(Request $request)
    {
        if(Permission::SubMenu('13',Auth::user()->role_id) == 0){
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
            $result = Setoranbank::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('bank','like','%'.$keyword.'%')
                ->orWhere('tgl_stor','like','%'.$keyword.'%')
                ->orWhere('rekening','like','%'.$keyword.'%')
               ;
            });
           $users = GymUser::where('user_id',Auth::user()->id)->get();
           foreach($users as $user){
                     $result->orWhere('gym_id',$user->gym_id);
                        }
                        $table = $result->paginate(15)
                    ;
                }else{
            $table = Setoranbank::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('bank','like','%'.$keyword.'%')
                ->orWhere('tgl_stor','like','%'.$keyword.'%')
                ->orWhere('rekening','like','%'.$keyword.'%')
               ;
            })
           
            ->paginate(15);
                }
            }else if(!empty($request->get('gym')) && empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $table = Setoranbank::orderBy('created_at','desc')
            ->where('gym_id',$request->gym)
            ->paginate(15);
               
            }
            else if(!empty($request->get('gym')) && !empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $keyword =$request->get('keyword');
                View::share('keyword', $keyword);
                 $table = Setoranbank::orderBy('created_at','desc')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('bank','like','%'.$keyword.'%')
                ->orWhere('tgl_stor','like','%'.$keyword.'%')
                ->orWhere('rekening','like','%'.$keyword.'%')
               ;
            })
            ->where('gym_id',$request->gym)
            ->paginate(15);
                
            }else{
                if(\App\Permission::CheckGym(Auth::user()->id)==1){
               $result = Setoranbank::orderBy('created_at','desc');
               $users = GymUser::where('user_id',Auth::user()->id)->get();
           foreach($users as $user){
                     $result->orWhere('gym_id',$user->gym_id);
                        }
                        $table = $result->paginate(15)
                    ;
          
                }else{
             $table = Setoranbank::orderBy('created_at','desc')->paginate(15);
                }
            }
        return view('dashboard.setoran.index')->with('table',$table)->with('selgym',$selgym)->with('keyword',$keyword)->with('gyms',$gyms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.setoran.create')->with('gyms',$gyms);
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
            'bank'             =>'required',
            'rekening'              =>'required',
            'total'             =>'required || Numeric',
            'tgl_stor'             =>'required',
            'gym_id'             =>'required',
            'deskripsi'         => 'required',            
        ])->setAttributeNames([
            'bank'             =>'Bank',
            'rekening'              =>'No Rekening',
            'total'              =>'Total',
            'tgl_stor'              =>'Tanggal Stor',
            'gym_id'             =>'Gym',
            'deskripsi'          =>'Deskripsi'
        ])->validate();
        $tglStoran = explode('-', $request->get('tgl_stor'));
        $setoran                  =   new Setoranbank;
        $setoran->bank           =   $request->get('bank');
        $setoran->rekening            =   $request->get('rekening');
        $setoran->total            =   $request->get('total');
        $setoran->tgl_stor            =   $tglStoran[2].'-'.$tglStoran[1].'-'.$tglStoran[0].' 00:00:00';
        $setoran->gym_id            =   $request->get('gym_id');
        $setoran->deskripsi         =   $request->get('deskripsi');
        $setoran->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Setoran Bank']));
        return redirect('/u/storan');
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
         if (\App\Permission::EditPer('14',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $storan    = Setoranbank::findOrFail($id);
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
        return view('dashboard.setoran.edit')->with('storan',$storan)->with('gyms',$gyms);
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
            'bank'             =>'required',
            'rekening'              =>'required',
            'total'             =>'required',
            'tgl_stor'             =>'required',
            'gym_id'             =>'required',
             'deskripsi'         => 'required',              
        ])->setAttributeNames([
            'bank'             =>'Bank',
            'rekening'              =>'No Rekening',
            'total'              =>'Total',
            'tgl_stor'              =>'Tanggal Stor',
            'gym_id'             =>'Gym',
             'deskripsi'         => 'Deskripsi'
        ])->validate();
        
        $tglStoran = explode('-', $request->get('tgl_stor'));
        $setoran                  =   Setoranbank::findOrFail($id);
        $setoran->bank           =   $request->get('bank');
        $setoran->rekening            =   $request->get('rekening');
        $setoran->total            =   $request->get('total');
        $setoran->tgl_stor            =   $tglStoran[2].'-'.$tglStoran[1].'-'.$tglStoran[0].' 00:00:00';
        $setoran->gym_id            =   $request->get('gym_id');
        $setoran->deskripsi         =   $request->get('deskripsi');
        $setoran->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Setoran Bank']));
        return redirect('/u/storan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(\App\Permission::DeletePer('13',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $setoran    =   Setoranbank::findOrFail($id);
        $setoran->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Setoran Bank']));
        return redirect('/u/storan');
    }
}
