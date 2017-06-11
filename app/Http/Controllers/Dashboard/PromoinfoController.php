<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Promoinfo;
use Auth;
class PromoinfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('29',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        Promoinfo::bootIndexPage($request->get('keyword'), ['title', 'description'],['title'=>'asc']);
        return view('dashboard.promoinfo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */  
    public function create()
    {
        return view('dashboard.promoinfo.create');
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
            'title'              =>'required',
            'description'        =>'required',
           'tgl_promo'           => 'required'
        ])->setAttributeNames([
            'title'              =>'Judul',
            'description'        =>'Pesan',
            'tgl_promo'           => 'Tanggal Promo'
        ])->validate();

        $promoinfo                   =   new Promoinfo;
        $promoinfo->title            =   $request->get('title');
        $promoinfo->description      =   $request->get('description');
        $promoinfo->status           =   $request->get('status');
         $range                  =   explode(" - ", $request->get('tgl_promo'));

        $promoinfo->harimulai        =   date("Y-m-d", strtotime($range[0]));
        $promoinfo->hariakhir        =   date("Y-m-d", strtotime($range[1]));
        $promoinfo->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Promo Info']));
        return redirect('/u/promoinfo');
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
         if (\App\Permission::EditPer('29',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $promo    =   Promoinfo::findOrFail($id);
        $tgl_event =  date("d-m-Y", strtotime($promo->harimulai)).' - '.date("d-m-Y", strtotime($promo->hariakhir));
        
        return view('dashboard.promoinfo.edit')->with('promo',$promo)->with('tgl_event',$tgl_event);
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
            'title'              =>'required',
            'description'        =>'required',
           'tgl_promo'           => 'required'
        ])->setAttributeNames([
            'title'              =>'Judul',
            'description'        =>'Pesan',
            'tgl_promo'           => 'Tanggal Promo'
        ])->validate();

        $promoinfo                   = Promoinfo::findOrFail($id);
        $promoinfo->title            =   $request->get('title');
        $promoinfo->description      =   $request->get('description');
        $promoinfo->status           =   $request->get('status');
         $range                  =   explode(" - ", $request->get('tgl_promo'));

        $promoinfo->harimulai        =   date("Y-m-d", strtotime($range[0]));
        $promoinfo->hariakhir        =   date("Y-m-d", strtotime($range[1]));
        $promoinfo->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Promo Info']));
        return redirect('/u/promoinfo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('29',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $promoinfo    = Promoinfo::findOrFail($id);
        $promoinfo->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Promo Info']));
        return redirect('/u/promoinfo');
    }
}
