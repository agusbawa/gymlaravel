<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Package;
use App\PackagePrice;
use App\Promo;
use Response;
use Carbon\Carbon;
use View;
use Auth;
class PackagelistPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('27',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $pakets = package::orderBy('title','asc')->get();
        $selpaket = "";
        PackagePrice::bootIndexPage($request->get('keyword'), ['title', 'description'],['title'=>'asc']);
        return view('dashboard.packagelistprice.index')->with('pakets',$pakets)->with('selpaket',$selpaket);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = Package::get();
        return view('dashboard.packagelistprice.create')->with('packages',$package);
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
            'day'              =>'required|integer|min:1',
            'price'              =>'required |integer|min:1',
            'package_id'              =>'required',
        ])->setAttributeNames([
            'title'              =>'Nama Harga Paket',
            'day'              =>'Lama',
            'price'              =>'Harga',
            'package_id'              =>'Kategori Paket',
        ])->validate();

        $newPackage            =   new PackagePrice;
        $newPackage->title         =   $request->get('title');
        $newPackage->day         =   $request->get('day');
        $newPackage->price         =   $request->get('price');
        if(empty($request->get('enable_front'))){
           $newPackage->enable_front = 0; 
        }else{
           $newPackage->enable_front = $request->get('enable_front'); 
        }
        $newPackage->package_id    =   $request->get('package_id');
        $newPackage->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Harga Paket']));
        return redirect('/u/packageprices');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $table = PackagePrice::where('package_id',$id)->paginate(15);
        $pakets = package::orderBy('title','asc')->get();
        $keyword = "";
        View::share('keyword',$keyword);
        return view('dashboard.packagelistprice.index')->with('table',$table)->with('pakets',$pakets)->with('selpaket',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  <1id></1id>
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (\App\Permission::EditPer('27',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $packagePrices    =   PackagePrice::findOrFail($id);
        $package = Package::get();
        
        return view('dashboard.packagelistprice.edit')->with('packages',$package)->with('packagePrice',$packagePrices);
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
            'day'              =>'required|integer|min:1',
            'price'              =>'required |integer|min:1',
            'package_id'              =>'required',
        ])->setAttributeNames([
            'title'              =>'Nama Harga Paket',
            'day'              =>'Lama',
            'price'              =>'Harga',
            'package_id'              =>'Kategori Paket',
        ])->validate();

        $newPackage                =   PackagePrice::findOrFail($id);
        $newPackage->title         =   $request->get('title');
        $newPackage->day         =   $request->get('day');
        $newPackage->price         =   $request->get('price');
        if(empty($request->get('enable_front'))){
           $newPackage->enable_front = 0; 
        }else{
           $newPackage->enable_front = $request->get('enable_front'); 
        }
        $newPackage->package_id    =   $request->get('package_id');
        $newPackage->save();

        request()->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Harga Paket']));
        return redirect('/u/packageprices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('27',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $packagePrices    =   PackagePrice::findOrFail($id);
        $packagePrices->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Harga Paket']));
        return redirect('/u/packageprices');
    }
    
   public function search(Request $request)
    {
        View::share('keyword', $request->get('keyword'));
        if(!isset($request)){
            return redirect('/u/packages');
        }
        # code...
        if($request->get('keyword')=="" && $request->get('kategori')!=""){
            $table = PackagePrice::orderBy('title','asc')->where('package_id',$request->kategori)->paginate(15);
        }else if($request->get('keyword')!="" && $request->get('kategori')==""){
        $table = PackagePrice::orderBy('title','asc')->where('title','like','%'.$request->keyword.'%')->paginate(15);
        }else if($request->get('keyword')!="" && $request->get('kategori')!=""){
            $table = PackagePrice::orderBy('title','asc')->where('title','like','%'.$request->keyword.'%')->where('package_id',$request->kategori)->paginate(15);
        }
        else{
            $table = PackagePrice::bootIndexPage($request->get('keyword'), ['title', 'description'],['title'=>'asc']);
        }
        $pakets = package::orderBy('title','asc')->get();
        return view('dashboard.packagelistprice.index')
        ->with('pakets',$pakets)
        ->with('table',$table)
        ->with('selpaket',$request->kategori);
    }
    
    public function ubah(Request $request,$id)
    {       $newPackage  = PackagePrice::findOrFail($id);
         if(empty($request->get('enable_front'))){
           $newPackage->enable_front = 0; 
        }else{
           $newPackage->enable_front = $request->get('enable_front'); 
        }
        $newPackage->save();
         request()->session()->flash('alert-success', trans('Colom enable front page terupdate'));
        return redirect('/u/packageprices');
    }
    public function getpromo($idpaket)
    {
        $promo = PackagePrice::findOrFail($idpaket);
        $selecpromo = $promo->promo()->where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))->where('qty','>','0');
        return response()->json(['promo'=>$selecpromo->get()->pluck('title','id'),'paket'=>$promo],200);
    }
}
