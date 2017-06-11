<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Promo;
use App\PackagePrice;
use App\PromoPackage;
use App\Transaction;
use Auth;
class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('226',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        //dd(Promo::isValid('445345'),date('Y-m-d'));
        Promo::bootIndexPage($request->get('keyword'), ['title', 'code'],['title'=>'asc']);
        return view('dashboard.promo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paket = PackagePrice::get();
        return view('dashboard.promo.create')->with('pakets',$paket);
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
            'code'              =>'required',
            'range'             =>'required',
            'unit'              =>'required',
            'qty'               =>'required|integer|min:1',
            'paket'             =>'required',
            'value'             =>'required|integer|min:1',

        ])->setAttributeNames([
            'title'             =>'Judul',
            'code'              =>'Kode Promo',
            'range'             =>'Masa Berlaku',
            'unit'              =>'',
            'qty'               =>'Jumlah',
            'paket'             =>'Paket',
            'value'            => 'Diskon'
        ])->validate();

        $promo                  =   new Promo;
        $promo->title           =   $request->get('title');
        $promo->code            =   $request->get('code');
        $range                  =   explode(" - ", $request->get('range'));
        $promo->start_date      =   date("Y-m-d", strtotime($range[0]));
        $promo->end_date        =   date("Y-m-d", strtotime($range[1]));
        $promo->unit            =   $request->get('unit');
        $promo->value           =   $request->get('value');
        $promo->qty             =   $request->get('qty',0);
        //$promo->is_enabled      =   $request->get('is_enabled',0);
        $promo->save();
        
        foreach($request->get('paket') as $paket){
        $propack = new PromoPackage;
        $propack->promo_id = $promo->id;
        $propack->package_price_id = $paket;
        $propack->save();
        }
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'News']));
        return redirect('/u/promos');
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
         if (\App\Permission::EditPer('226',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $promo    =   Promo::findOrFail($id);
        $paket = PackagePrice::get();
        $promopaket = PromoPackage::where('promo_id',$id)->get();
       
        return view('dashboard.promo.edit')->with('promo',$promo)->with('pakets',$paket)->with('promopaket',$promopaket)->with('jump',$promo->package()->get());
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
            
            'range'             =>'required',
            'value'              =>'required|integer|min:1',
            'qty'               =>'required|integer|min:1',
            'paket'             =>'',
            'unit'              =>'required'
        ])->setAttributeNames([
            'title'             =>'Judul',
            'qty'               =>'diskon',
            'range'             =>'Masa Berlaku',
            'value'              =>'Diskon',
            'qty'               =>'Jumlah',
            'paket'               =>'Paket',

        ])->validate();

        $promo                  =   Promo::findOrFail($id);
        $promo->title           =   $request->get('title');

        $range                  =   explode(" - ", $request->get('range'));
        $promo->start_date      =   date("Y-m-d", strtotime($range[0]));
        $promo->end_date        =   date("Y-m-d", strtotime($range[1]));
        $promo->unit            =   $request->get('unit');
        $promo->value           =   $request->get('value');
        $promo->qty             =   $request->get('qty');
        //$promo->is_enabled      =   $request->get('is_enabled',0);
        $promo->save();
        if(!empty($request->get('paket'))){
                foreach($request->get('paket') as $paket){
                $propack = new PromoPackage;
                $propack->promo_id = $promo->id;
                $propack->package_price_id = $paket;
                $propack->save();
            }
        }
        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'News']));
        return redirect('/u/promos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('226',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $promo    =   Promo::findOrFail($id);
        $transaksi = Transaction::where('promo_id',$id)->get();
        if($transaksi->count() > 0){
            request()->session()->flash('alert-error', trans('Promo Sudah digunakan'));
        return redirect('/u/promos');
        }
        $promo->package()->detach();
        $promo->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Promo']));
        return redirect('/u/promos');
    }
}
