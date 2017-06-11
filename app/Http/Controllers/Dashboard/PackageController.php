<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Package;
use Auth;
class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('26',Auth::user()->role_id) == 0){
            return redirect()->back();
      }

        if(!empty($request->get('keyword')))
        $table = Package::orderBy('title','asc')->where('title','like','%'.$request->keyword.'%')->get();
        else
        $table=Package::bootIndexPage($request->get('keyword'), ['title', 'description'],['title'=>'asc']); 
        return view('dashboard.package.index')->with('table',$table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.package.create');
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
        ])->setAttributeNames([
            'title'              =>'Nama Paket',
        ])->validate();

        $package                =   new Package;
        $package->title         =   $request->get('title');
        $package->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Paket']));
        return redirect('/u/packages/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/u/packagesprices/'.$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (\App\Permission::EditPer('26',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $package                =   Package::findOrFail($id);
        return view('dashboard.package.edit')->with('package',$package);
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
        ])->setAttributeNames([
            'title'              =>'Nama Paket',
        ])->validate();

        $package                =   Package::findOrFail($id);
        $package->title         =   $request->get('title');
        $package->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Paket']));
        return redirect('/u/packages/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('26',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $package    =   Package::findOrFail($id);
        if($package->gyms()->count() > 0){
            request()->session()->flash('alert-error', trans('regym.fail_deleting', ['barrier_count' => $package->gyms()->count(),'barrier'=>'Gym']));
        	return redirect()->back();
        }
         if($package->packagePrice()->count() > 0){
            request()->session()->flash('alert-error', trans('regym.fail_deleting', ['barrier_count' => $package->gyms()->count(),'barrier'=>'Daftar Harga']));
        	return redirect()->back();
        }
        $package->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Paket']));
        return redirect('/u/packages');
    }
    
    public function listharga(Request $request, $id){
        if($request->ajax()){
//            return $zonas;
            $package  = Package::findOrFail($id);
            return $package->packagePrice()->get()->toJson();
        }
    }
    public function search(Request $request)
    {
        # code...
        if(empty($request->keyword)){

        }else{
        $table = Package::orderBy('title','asc')->where('title','like','%'.$request->keyword.'%')->get();
        return view('dashboard.package.index')
        ->with('table',$table)
        ;
        }
    }
}
