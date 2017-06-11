<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Member;
use App\Gym;
use App\Package;
use App\PackagePrice;
use App\Transaction;
use App\TrasactionPayment;
use App\Promo;
use Response;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Transaction::bootIndexPage($request->get('keyword'), ['name'],['created_at'=>'asc']);
        return view('dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members        =   Member::get();
        $gyms           =   Gym::get();
        $packages       =   Package::get();
        $promos         = Promo::get();
        return view('dashboard.transaction.create')->with('members',$members)->with('gyms',$gyms)->with('packages',$packages)->with('promos',$promos);
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
        \Validator::make($request->all(),[
            'member' => 'required',
            'gym'=> 'required', 
            'packages'=>'required',
            'promo'=>'nullable',
            'discount'=>'nullable',
            'unit'=>'nullable',
            'payment'=>'required',
            'transaksi'=>'nullable',
            'status'=>'required',
            ])->setAttributeNames([
            'member'             =>'Member',
            'gym'                   =>'Gym',
            'packages'             =>'Paket',
            'promo'              =>'Promo',
            'discount'              =>'Discount',
            'unit'              =>'Unit',
            'payment'           =>'Payment Method',
            'transaksi'         =>'Nomor Transaksi',
            'status'            =>'Status',
        ])->validate();

        $price = PackagePrice::find($request->get('packages'));
        if($request->get('promo')!=0){
        $promoDiscount = Promo::find($request->get('promo'));
            if($promoDiscount->unit == "PERCENTAGE"){
                $total = $price->price - ($price->price * ($promoDiscount->value / 100));
            }
            else if($promoDiscount->unit == "NOMINAL"){
                $total = $price->price - $promoDiscount->value;
            }else{
                $total = $price->price;
            }
        }else{$total = $price->price;}   

        

        $transaksi                      = new Transaction;
        $transaksi->member_id           = $request->get('member');
        $transaksi->gym_id              = $request->get('gym');
        $transaksi->package_price_id    = $request->get('packages');
        $transaksi->promo_id            = $request->get('promo');
        $transaksi->status              = $request->get('status');
        $transaksi->payment_method      = $request->get('payment');
        $transaksi->total               = $total;
        if(empty($request->get('transaksi'))){

        }else{
             $transaksi->refrences_payment   = $request->get('transaksi');
        }
       
        $transaksi->save();
        if($request->get('status')=="Active"){
                if($request->get('promo')!= 0){
                $promo = Promo::findOrFail($request->get('promo'));
                $promo->qty = $promo->qty - 1;
                $promo->save();
            }
        } 
        $payment = new TrasactionPayment;
        $payment->pacakge_price_id = $request->get('packages');
        $payment->promo_id = $request->get('promo');
        $payment->transaction_id = $transaksi->id;
        $payment->save();
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Transaction']));
        return redirect('/u/transactions');
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
        //
        $transaction  = Transaction::findOrFail($id);
        $members        =   Member::get();
        $gyms           =   Gym::get();
        $packages       =   Package::get();
        $promos         =   Promo::get();
        return view('dashboard.transaction.edit')->with('members',$members)->with('gyms',$gyms)->with('packages',$packages)->with('promos',$promos)->with('transaction',$transaction);
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
        \Validator::make($request->all(),[
            'member' => 'required',
            'gym'=> 'required', 
            'packages'=>'required',
            'promo'=>'nullable',
            'discount'=>'nullable',
            'unit'=>'nullable',
            'payment'=>'required',
            'transaksi'=>'nullable',
            'status'=>'required',
            ])->setAttributeNames([
            'member'             =>'Member',
            'gym'              =>'Gym',
            'packages'             =>'Paket',
            'promo'              =>'Promo',
            'discount'              =>'Discount',
            'unit'              =>'Unit',
            'payment'           =>'Payment Method',
            'transaksi'         =>'Nomor Transaksi',
            'status'            =>'Status',
        ])->validate();

        $price = PackagePrice::find($request->get('packages'));
        if($request->get('promo')!=0){
        $promoDiscount = Promo::find($request->get('promo'));
            if($promoDiscount->unit == "PERCENTAGE"){
                $total = $price->price - ($price->price * ($promoDiscount->value / 100));
            }
            else if($promoDiscount->unit == "NOMINAL"){
                $total = $price->price - $promoDiscount->value;
            }else{
                $total = $price->price;
            }
        }else{$total = $price->price;}   

        $transaksi                      = new Transaction;
        $transaksi->member_id           = $request->get('member');
        $transaksi->gym_id              = $request->get('gym');
        $transaksi->package_price_id    = $request->get('packages');
        $transaksi->promo_id            = $request->get('promo');
        $transaksi->status              = $request->get('status');
        $transaksi->payment_method      = $request->get('payment');
        $transaksi->discount            = $request->get('discount');
        $transaksi->total               = $total;
        $transaksi->refrences_payment   = $request->get('transaksi');
        $transaksi->save(); 
        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Transaction']));
        return redirect('/u/transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Transaction::find($id)->delete();request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Transaction']));
        return redirect('/u/transactions');
    }
    public function lookdiscount($id){
        $price=Promo::find($id);
        return Response::json($price,200);
    }
    public function lookprice($id)
    {
        # code...
        $data = PackagePrice::find($id);
        return Response::json($data,200);
    }
}
