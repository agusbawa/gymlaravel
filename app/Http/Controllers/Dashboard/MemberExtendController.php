<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use App\Package;
use App\PackagePrice;
use App\Transaction;
use App\Gym;
use App\TrasactionPayment;
use App\Promo;
use App\PromoPackage;
use Illuminate\Support\Facades\Mail;
use App\Mail\extendMember;
use App\Mail\mailCreatedCs;
use App\MemberHistory;
use App\CardMember;
use View;
use App\Mail\invoicepembayaran;
use Auth;
class MemberExtendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\App\Permission::SubMenu('16',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        return view('dashboard.member.extend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $card     =    Member::where('card',$request->get('member'))->first();

        if (is_null($card)) {
            request()->session()->flash('alert-error', 'Member tidak ditemukan');
            return redirect()->back()->withInput();
        }
        $member =  Member::find($card->member_id);
        return redirect('/u/members/extend/'.$card->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
       
       View::share('keyword','');
        $member     =    Member::find($id);
        $transaksis = Transaction::where('member_id',$id)->paginate(5);
        if (is_null($member)) {
            request()->session()->flash('alert-error', 'ID Member tidak ditemukan');
            return redirect('/u/members/extend');
        }
         $promos         =   Promo::get();
        $packages       =   Package::get();
        $packagePrice   =   PackagePrice::find($member->package_id);
      
        $paket          =   PackagePrice::where('package_id',$packagePrice->package_id)->get();
        
        $gyms           =   Gym::get();
        return view('dashboard.member.extend.view')->with('pakets',$paket)->with('transaksis',$transaksis)->with('member',$member)->with('packages',$packages)->with('package_price',$packagePrice)->with('gyms',$gyms)->with('promos',$promos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $member         =   Member::findOrFail($id);
        $packagePrice   =   PackagePrice::find($request->get('paket'));

        // Check Promo Validity
        //$promovalid          =   Promo::backValid($request->get('promo'),$request->get('packages'));
         if(empty($request->get('promo'))){
            $validation = Transaction::validasi($request->get('paket'));
            $total = $packagePrice->price;
            $discount = 0;
        }else{
            $promo         =   Promo::find($request->get('promo'));
            $validation = Transaction::validasi($request->get('paket'),$request->get('promo'));
            if ($promo->unit=="NOMINAL") {
            $discount   =   $packagePrice->price - $promo->value;
            if ($discount < 0) {
                $discount   =   0;
            }
        }
        elseif ($promo->unit == "PERCENTAGE") {
            $discount   =   $packagePrice->price * $promo->value / 100;
        }
        $total = $packagePrice->price - $discount;
        $promo->qty     -=   1;
        $promo->save();
        }
        if($validation==false){
            $request->session()->flash('alert-error', 'Promo tidak valid');
            return redirect()->back()->withInput();
        }

            if ($member->expired_at < \Carbon\Carbon::now()) {
                $expire     =   \Carbon\Carbon::now()->addDays($packagePrice->day);
                $extend    = \Carbon\Carbon::now();
            }
            else if($member->expired_at > \Carbon\Carbon::now())
            {
                $extend     = $member->expired_at;
                $expire     =   $member->expired_at->addDays($packagePrice->day);
            }else{

            }

       
        
        

        $transaction                    =   new Transaction;
        $transaction->gym_id            =   $request->get('gym');
        $transaction->package_price_id  =   $packagePrice->id;
        $transaction->member_id         =   $member->id;
        $transaction->code              = str_random(8);
        if(empty($request->get('promo'))){
            $transaction->promo_id  = 0;
        }else{
        $transaction->promo_id          =   $request->get('promo');
        }
        $transaction->status            =   "Active";   
       // $transaction->discount          =   $discount;
        $transaction->total             =   $total;
       
        $transaction->save();
        
         $member->expired_at     =   $expire;
         $member->extended_at     =   $extend;
         $member->type             ="extends";
        $member->save();
        $payment = new TrasactionPayment;
        $payment->transaction_id = $transaction->id;
        $payment->pacakge_price_id = $request->get('paket');
        if(empty($request->get('promo'))){
            $payment->promo_id  = 0;
        }else{
        $payment->promo_id          =   $request->get('promo');
        }
        $payment->payment_method    =  $request->get('payment');
        if(!empty($request->get('transaksi'))){
            $payment->refrences_payment = $request->get('transaksi');

        }else{
            $payment->refrences_payment = '0';
        }

        $payment->total_bayar = $request->get('bayar');
        $payment->save();
        $member->processAttendance($request->get('gym'));
        $memberSend  = Member::findOrFail($member->id);
        $pass = $memberSend->password;
        $email = $memberSend->email;
               
        Mail::to($email)->send(new invoicepembayaran($transaction->code));
         Mail::to($email)->send(new extendMember($email));
        Mail::to(Auth::user()->email)->send(new mailCreatedCs($email,$pass));
        MemberHistory::DataAktifasiMasuk($member->id,$request->get('gym'),$request->get('paket'),$expire,$request->get('promo'),'extend');   
        request()->session()->flash('alert-success', 'Member telah diperpanjang');
        return redirect('/u/members/'.$member->id);
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
    }
}
