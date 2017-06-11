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
use App\TemplateEmail;
use App\TiketMessage;
use Auth;
class TemplateEmailController extends Controller
{
    public function index()
    {
        if(\App\Permission::SubMenu('225',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        # code...
        $template = TemplateEmail::get();
        return view('dashboard.templateemail.index')->with('template',$template);
    }
    public function edit($id)
    {
        # code...
        $template = TemplateEmail::findOrFail($id);
        return view('dashboard.templateemail.edit')->with('template',$template);
    }
    public function update($id,Request $request)
    {
        # code...
        \Validator::make($request->all(),[
            'title'             =>'required',
            'description'              =>'required',
            
        ])->setAttributeNames([
            'title'             =>'Title',
            'description'              =>'Deskripsi',
           
        ])->validate();

        $template = TemplateEmail::findOrFail($id);
        $template->title = $request->title;
        $template->pesan = $request->description;
        $template->save(); 
        $request->session()->flash('alert-success', 'Template email telah di update');
        return redirect('/u/templateemail');
    }
}