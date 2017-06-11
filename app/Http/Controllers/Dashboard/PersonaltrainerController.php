<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Personaltrainer;
use App\Gym;
use App\Member;
use View;
use App\GymUser;
use Auth;
class PersonaltrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('10',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $gyms    = Gym::orderBy('title','asc')->get();
        $members = Member::orderBy('name','asc')->get();
        $selgym = "";
        $keyword = "";
        View::share('keyword', $keyword);
        if(empty($request->get('gym')) && !empty($request->get('keyword'))){
               
                $keyword = $request->get('keyword');
                View::share('keyword', $keyword);
                 if(\App\Permission::CheckGym(Auth::user()->id)==1){
            $result = Personaltrainer::orderBy('created_at','desc')
            ->join('members','members.id','=','personal_trainer.member_id')
            ->join('gyms','gyms.id','=','personal_trainer.gym_id')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('personal_trainer.name','like','%'.$keyword.'%')
                ->orWhere('tgl_bayar','like','%'.$keyword.'%')
                ->orWhere('members.name','like','%'.$keyword.'%');
            })
            ->select('members.name as membersname','gyms.title as titlegyms','personal_trainer.*');
            $users = GymUser::where('user_id',Auth::user()->id)->get();
            foreach($users as $user){
                $result->orWhere('personal_trainer.gym_id',$user->gym_id);
            }
            $table = $result->paginate(15)
            ;
                 }else{
                      $table = Personaltrainer::orderBy('created_at','desc')
            ->join('members','members.id','=','personal_trainer.member_id')
            ->join('gyms','gyms.id','=','personal_trainer.gym_id')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('personal_trainer.name','like','%'.$keyword.'%')
                ->orWhere('tgl_bayar','like','%'.$keyword.'%')
                ->orWhere('members.name','like','%'.$keyword.'%');
            })
            ->select('members.name as membersname','gyms.title as titlegyms','personal_trainer.*')
           
            ->paginate(15)
            ;
                 }
            }else if(!empty($request->get('gym')) && empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $table = Personaltrainer::orderBy('created_at','desc')
            ->join('members','members.id','=','personal_trainer.member_id')
            ->join('gyms','gyms.id','=','personal_trainer.gym_id')
            ->where('gyms.id',$request->gym)
            ->select('members.name as membersname','gyms.title as titlegyms','personal_trainer.*')
            ->paginate(15);
               
            }
            else if(!empty($request->get('gym')) && !empty($request->get('keyword'))) {
                $selgym = $request->get('gym');
                $keyword =$request->get('keyword');
                View::share('keyword', $keyword);
                 $table = Personaltrainer::orderBy('created_at','desc')
            ->join('members','members.id','=','personal_trainer.member_id')
            ->join('gyms','gyms.id','=','personal_trainer.gym_id')
            ->where(function($query) use ($keyword){
                
                $query->orWhere('personal_trainer.name','like','%'.$keyword.'%')
                ->orWhere('tgl_bayar','like','%'.$keyword.'%')
                ->orWhere('members.name','like','%'.$keyword.'%');
            })
            ->where('gyms.id',$request->gym)
            ->select('members.name as membersname','gyms.title as titlegyms','personal_trainer.*')
            ->paginate(15);
                
            }else{
                 if(\App\Permission::CheckGym(Auth::user()->id)==1){
               $result = Personaltrainer::orderBy('created_at','desc')
            ->join('members','members.id','=','personal_trainer.member_id')
            ->join('gyms','gyms.id','=','personal_trainer.gym_id')
            ->select('members.name as membersname','gyms.title as titlegyms','personal_trainer.*');
            $users = GymUser::where('user_id',Auth::user()->id)->get();
             foreach($users as $user){
                $result->orWhere('personal_trainer.gym_id',$user->gym_id);
            }
            $table = $result->paginate(15)
            ;
                 }else{
            $table = Personaltrainer::orderBy('created_at','desc')
            ->join('members','members.id','=','personal_trainer.member_id')
            ->join('gyms','gyms.id','=','personal_trainer.gym_id')
            ->select('members.name as membersname','gyms.title as titlegyms','personal_trainer.*')
            ->paginate(15);
                 }
            }
        return view('dashboard.personaltrainer.index')->with('table',$table)->with('gyms',$gyms)->with('selgym',$selgym)->with('members',$members);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gyms    = Gym::orderBy('title','asc')->get();
        $members = Member::orderBy('name','asc')->get();
        return view('dashboard.personaltrainer.create')->with('gyms',$gyms)->with('members',$members);
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
            'fee_trainer'              =>'required || Numeric | min:1',
            'member_id'             =>'required',
            'gym_id'             =>'required',
            'fee_gym'              =>'required || Numeric | min:1',
            'metode'              =>'required',
            'keterangan'          =>'',
            'tgl_bayar'             =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'keterangan'        =>'Keterangan',
            'fee_trainer'              =>'Fee Trainer',
            'member_id'         =>'Memeber',
            'gym_id'             =>'Gym',
            'fee_gym'              =>'Fee Gym',
            'metode'                => 'Payment Method',
            'tgl_bayar'             =>'Tanggal bayar'
        ])->validate();

        $personal                  =   new Personaltrainer;
        $personal->name           =   $request->get('name');
        $personal->fee_trainer            =   $request->get('fee_trainer');
        $personal->member_id            = $request->get('member_id');
        $personal->gym_id            =   $request->get('gym_id');
        $personal->fee_gym            =   $request->get('fee_gym');
        $personal->keterangan           = $request->get('keterangan');
        $personal->tgl_bayar          =    date('Y-m-d',strtotime($request->get('tgl_bayar')));
        if(empty($request->get('keterangan'))){

        }else{
            $personal->keterangan = $request->get('keterangan');
        }
        $personal->payment_method    = $request->get('metode');
        $personal->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Personal Trainer']));
        return redirect('/u/personaltrainer');
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
         if (\App\Permission::EditPer('10',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $personal    = Personaltrainer::findOrFail($id);
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
        $members = Member::orderBy('name','asc')->get();
        return view('dashboard.personaltrainer.edit')->with('personal',$personal)->with('gyms',$gyms)->with('members',$members);
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
            'fee_trainer'              =>'required || Numeric | min:1',
            'gym_id'             =>'required',
            'fee_gym'              =>'required || Numeric |min:1',
            'member_id'             =>'required',
             'metode'              =>'required',
             'keterangan'           =>'',
            'tgl_bayar'             =>'required'
        ])->setAttributeNames([
            'name'             =>'Nama',
            'keterangan'      =>  'Keterangan',
            'fee_trainer'          =>'Fee Trainer',
            'gym_id'             =>'Gym',
            'fee_gym'              =>'Fee Gym',
            'member_id'             =>'Member',
             'metode'              =>'Metode Pembayaran',
            'tgl_bayar'             =>'Tanggal Bayar'
        ])->validate();

        $personal                  = Personaltrainer::findOrFail($id);
        $personal->name           =   $request->get('name');
        $personal->fee_trainer            =   $request->get('fee_trainer');
        $personal->gym_id            =   $request->get('gym_id');
        $personal->member_id        = $request->get('member_id');
        $personal->keterangan           = $request->get('keterangan');
        $personal->fee_gym            =   $request->get('fee_gym');
        if(empty($request->get('keterangan'))){

        }else{
            $personal->keterangan = $request->get('keterangan');
        }
        $personal->tgl_bayar          =    date('Y-m-d',strtotime($request->get('tgl_bayar')));
        $personal->payment_method    = $request->get('metode');
        $personal->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Personal Trainer']));
        return redirect('/u/personaltrainer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if(\App\Permission::DeletePer('10',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $personal    =   Personaltrainer::findOrFail($id);
        $personal->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Personal Trainer']));
        return redirect('/u/personaltrainer');
    }
}
