<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Agenda;
use Auth;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('31',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        Agenda::bootIndexPage($request->get('keyword'), ['title'],['title'=>'asc']);
        return view('dashboard.event.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        \Validator::make($request->all(), [
            'title'     => 'required',
            'tgl_event'     => 'required',
            'jam'     => 'required',
            'jamberakhir' => "",
            'deskripsi' =>  "required",
            'tempat' =>  "required"
        ])->setAttributeNames([
            'title'   => 'Title',
            'tgl_training'  => 'Tanggal Training',
            'jam'    =>   'Jam',
            'jamberakhir'   =>     'Jam Berakhir',
            'deskripsi'     =>     'Deskripsi',
            'tempat' =>  "Tempat"
        ])->validate();
         
        $data               = new Agenda;
        $data->title        = $request->title;
        $range                  =   explode(" - ", $request->get('tgl_event'));
        $data->date         =   date("Y-m-d", strtotime($range[0]));
        $data->end_date        =   date("Y-m-d", strtotime($range[1]));
        $data->start_time           = $request->jam;
        if($request->jamberakhir != ""){
        $data->end_time   = $request->jamberakhir;
        }
        $data->description = $request->deskripsi;
        $data->tempat = $request->tempat;
        $data->save();
        $request->session()->flash('alert-success', trans('regym.success_created', ['name' => 'Event']));
        return redirect('/u/events');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (\App\Permission::EditPer('31',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        //
        $event = Agenda::findOrFail($id);
        $date =date('d-m-Y',strtotime($event->date)) ." -   ".date('d-m-Y',strtotime($event->end_date));
        return view('dashboard.event.edit')->with('event',$event)->with('date',$date);
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
        //
         \Validator::make($request->all(), [
            'title'     => 'required',
            'tgl_event'     => 'required',
            'jam'     => 'required',
            'jamberakhir' => "",
            'deskripsi' =>  "required",
            'tempat' =>  "required"
        ])->setAttributeNames([
            'title'   => 'Title',
            'tgl_training'  => 'Tanggal Training',
            'jam'    =>   'Jam',
            'jamberakhir'   =>     'Jam Berakhir',
            'deskripsi'     =>     'Deskripsi',
            'tempat' =>  "Tempat"
        ])->validate();
         
        $data               = Agenda::FindOrFail($id);
        $data->title        = $request->title;
        $range                  =   explode(" - ", $request->get('tgl_event'));
        $data->date         =   date("Y-m-d", strtotime($range[0]));
        $data->end_date        =   date("Y-m-d", strtotime($range[1]));
        $data->start_time           = $request->jam;
        if($request->jamberakhir != ""){
        $data->end_time   = $request->jamberakhir;
        }
        $data->description = $request->deskripsi;
        $data->tempat = $request->tempat;
        $data->save();
        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Event']));
        return redirect('/u/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('31',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        //
         $gym    =   Agenda::findOrFail($id);
         $gym->delete();
          request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Event']));
        return redirect('/u/events');
    }
}
