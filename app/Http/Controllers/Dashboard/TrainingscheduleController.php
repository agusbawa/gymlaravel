<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trainingschedule;
use App\Gym;
use Auth;
class TrainingscheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('28',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $gyms    = Gym::orderBy('title','asc')->get();
        Trainingschedule::bootIndexPage($request->get('keyword'), ['title'],['created_at'=>'asc']);
        return view('dashboard.schedule.index')->with('gyms',$gyms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.schedule.create')->with('gyms',$gyms);
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
            'title'             =>'required',
            'tgl_training'              =>'required',
            'jam'             =>'required',
            'profile_trainer'             =>'required',
            'durasi'             =>'required',
            'gym_id'             =>'required',
            'instruktur'             =>'required'
        ])->setAttributeNames([
            'title'             =>'Nama Training',
            'tgl_training'              =>'Tanggal Training',
            'jam'             =>'Jam Training',
            'profile_trainer'             =>'Profile_trainer',
            'durasi'             =>'Durasi',
            'gym_id'             =>'Gym',
            'instruktur'             =>'Instruktur',
        ])->validate();

        $train                  =   new Trainingschedule;
        $train->title           =   $request->get('title');
        $train->tgl_training            =   date('Y-m-d',strtotime($request->get('tgl_training')));
        $train->gym_id            =   $request->get('gym_id');
        $train->jam            =   $request->get('jam');
        $train->profile_trainer            =   $request->get('profile_trainer');
        $train->durasi            =   $request->get('durasi');
        $train->instruktur            =   $request->get('instruktur');
        $train->gym_id            =   $request->get('gym_id');
        $train->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Training Schedule']));
        return redirect('/u/schedule');
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
         if (\App\Permission::EditPer('28',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $train    = Trainingschedule::findOrFail($id);
        $gyms    = Gym::orderBy('title','asc')->get();
        return view('dashboard.schedule.edit')->with('train',$train)->with('gyms',$gyms);
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
            'title'             =>'required',
            'tgl_training'              =>'required',
            'jam'             =>'required',
            'profile_trainer'             =>'required',
            'durasi'             =>'required',
            'gym_id'             =>'required',
            'instruktur'             =>'required'
        ])->setAttributeNames([
            'title'             =>'Nama Training',
            'tgl_training'              =>'Tanggal Training',
            'jam'             =>'Jam Training',
            'profile_trainer'             =>'Profile_trainer',
            'durasi'             =>'Durasi',
            'gym_id'             =>'Gym',
            'instruktur'             =>'Instruktur',
        ])->validate();

        $train                  = Trainingschedule::findOrFail($id);
       $train->title           =   $request->get('title');
        $train->tgl_training            =   date('Y-m-d',strtotime($request->get('tgl_training')));
        $train->gym_id            =   $request->get('gym_id');
        $train->jam            =   $request->get('jam');
        $train->profile_trainer            =   $request->get('profile_trainer');
        $train->durasi            =   $request->get('durasi');
        $train->instruktur            =   $request->get('instruktur');
        $train->gym_id            =   $request->get('gym_id');
        $train->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Training Schedule']));
        return redirect('/u/schedule');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('28',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $train    =   Trainingschedule::findOrFail($id);
        $train->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Training Schedule']));
        return redirect('/u/schedule');
    }
}
