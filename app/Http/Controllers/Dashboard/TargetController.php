<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trainingschedule;
use App\Gym;
use App\TargetGym;
use App\Personaltrainer;
use Auth;
use App\GymUser;
class TargetController extends Controller
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('228',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $table = TargetGym::authIndexPage($request->get('keyword'), ['title'],['created_at'=>'asc']);
        return view('dashboard.target.index');
    }
    public function create()
    {
        $personals = Personaltrainer::orderBy('id','desc')->get();
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
        $lasttarget = TargetGym::orderBy('id','desc')->first();
       return view('dashboard.target.create')
       ->with('personals',$personals)
       ->with('gyms',$gyms)
       ->with('lasttarget',$lasttarget)
       ;
    }
    public function store(Request $request)
    {
        # code...
                        
        
        \Validator::make($request->all(),[
            'gym_id'                =>'required',
            'returner'             =>'required || integer || min:1',
            'newmember'             =>'required || integer || min:1',
            'target'             =>'required || integer || min:1',
            'gym_id'             =>'required',
            'month'             =>'required',
            'year'              =>'required'
        ])->setAttributeNames([
            'gym_id'                =>'Gym',
            'returner'             =>'Returner',
            'newmember'             =>'New Member',
            'target'             =>'Target Omzet',
            'gym_id'             =>'Gym',
            'month'             =>'Bulan',
            'year'              =>'Tahun'
        ])->validate();

        $data = new TargetGym;
        $data->returner = $request->get('returner');
        $data->new_member_price = $request->get('newmember');
        $data->bulan = $request->get('month');
        $data->target_omset = $request->get('target');
        $data->gym_id = $request->get('gym_id');
        $data->year = $request->get('year');
        $data->save();
         $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Target']));
        return redirect('/u/target');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        # code...
        if(\App\Permission::DeletePer('228',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        TargetGym::findOrFail($id)->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Target']));
        return redirect('/u/target');
    }

    public function edit($id)
    {
         if (\App\Permission::EditPer('228',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        # code...
        $target = TargetGym::findOrFail($id);
        $personals = Personaltrainer::orderBy('id','desc')->get();
        $gyms = Gym::orderBy('id','desc')->get();

       return view('dashboard.target.edit')
       ->with('personals',$personals)
       ->with('gyms',$gyms)
       ->with('target',$target)
       ;
    }
    public function update(Request $request,$id)
    {
        # code...
                        
        
        \Validator::make($request->all(),[
            'gym_id'                =>'required',
            'returner'             =>'required || Numeric',
            'newmember'             =>'required || Numeric',
            'target'             =>'required || Numeric',
            'gym_id'             =>'required',
            'month'             =>'required',
            'year'              =>'required'
        ])->setAttributeNames([
            'gym_id'                =>'Gym',
            'returner'             =>'Returner',
            'newmember'             =>'New Member',
            'target'             =>'Target Omzet',
            'gym_id'             =>'Gym',
            'month'             =>'Bulan',
            'year'              =>'Tahun'
        ])->validate();

        $data = TargetGym::findOrFail($id);
        $data->returner = $request->get('returner');
        $data->new_member_price = $request->get('newmember');
        $data->bulan = $request->get('month');
        $data->target_omset = $request->get('target');
        $data->gym_id = $request->get('gym_id');
        $data->year = $request->get('year');
        $data->save();
         $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Target']));
        return redirect('/u/target');
    }

}
