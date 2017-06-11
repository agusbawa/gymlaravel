<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PackagePrice;
use App\Package;
use App\PromoPackage;
class PackagePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, \App\Package $package)
    {
        
        if($request->ajax()){
            return $package->packagePrice()->get()->toJson();
        }
         
        
        PackagePrice::bootIndexPage($request->get('keyword'), ['title', 'description'],['title'=>'asc'], null, function($object) use ($package){
            return $object->where('package_id','=',$package->id);
        });
        
        return view('dashboard.package-price.index')->with('package',$package);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(\App\Package $package)
    {
        return view('dashboard.package-price.create')->with('package',$package);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, \App\Package $package)
    {
        \Validator::make($request->all(),[
            'title'              =>'required',
            'day'              =>'required',
            'price'              =>'required',
        ])->setAttributeNames([
            'title'              =>'Nama Harga Paket',
            'day'              =>'Lama',
            'price'              =>'Harga',
        ])->validate();

        $newPackage                =   new PackagePrice;
        $newPackage->title         =   $request->get('title');
        $newPackage->day         =   $request->get('day');
        $newPackage->price         =   $request->get('price');
        $newPackage->enable_front = $request->get('enable_front');
        $newPackage->package_id    =   $package->id;
        $newPackage->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Harga Paket']));
        return redirect('/u/packages/'.$package->id.'/prices');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Package $package, $id)
    {
        $packagePrices    =   PackagePrice::findOrFail($id);
        return view('dashboard.package-price.edit')->with('package',$package)->with('packagePrice',$packagePrices);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Package $package, $id)
    {
        \Validator::make($request->all(),[
            'title'              =>'required',
            'day'              =>'required',
            'price'              =>'required',
        ])->setAttributeNames([
            'title'              =>'Nama Harga Paket',
            'day'              =>'Lama',
            'price'              =>'Harga',
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
        
        $newPackage->package_id    =   $package->id;
        $newPackage->save();

        request()->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Harga Paket']));
        return redirect('/u/packages/'.$package->id.'/prices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\Package $package, $id)
    {
        $packagePrices    =   PackagePrice::findOrFail($id);
        
        $packagePrices->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Harga Paket']));
        return redirect('/u/packages/'.$package->id.'/prices');
    }
    
    public function checkpaket($idpaket)
    {
       

    }
}
