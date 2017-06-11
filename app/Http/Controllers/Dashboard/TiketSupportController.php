<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Trainingschedule;
use App\Gym;
use App\TargetGym;
use App\Personaltrainer;
use App\TiketSupport;
use App\Member;
use App\TiketMessage;
use Auth;
class TiketSupportController extends Controller
{
    public function index()
    {
        if(\App\Permission::SubMenu('33',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        # code...
        $table = TiketSupport::orderBy('created_at','desc')->get();
        return view('dashboard.tiketsupport.index')
        ->with('table',$table);
    }
     public function edit($id)
    {
        # code...
        $tiketsupport = TiketSupport::findOrFail($id);
        $messages = TiketMessage::where('tiket_id',$tiketsupport->id)->get();
        return view('dashboard.tiketsupport.edit')->with('tiketsupport',$tiketsupport)->with('messages',$messages);
    }
    public function reply($id,Request $request)
    {
        $data = new TiketMessage;
        $data->pesan = $request->pesan;
        $data->tiket_id = $id;
        $data->author = 0;
        $data->save();
        $support = tiketSupport::findOrFail($id);
        $support->status = "Reply";
        $support->save();

        $tiketsupport = TiketSupport::findOrFail($id);
        $messages = TiketMessage::where('tiket_id',$tiketsupport->id)->get();
        $member = Member::find($support->member_id);
         Mail::to($member->email)->send(new tiketsuport($member->email,$request->pesan));
        $request->session()->flash('alert-success', trans('Reply dilakukan'));
        return view('dashboard.tiketsupport.edit')->with('tiketsupport',$tiketsupport)->with('messages',$messages);
    }
}