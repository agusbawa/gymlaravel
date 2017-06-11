<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Member;
use App\Gym;
use App\Package;
use App\PackagePrice;
use App\Transaction;
use App\TrasactionPayment;
use App\Promo;
use Carbon\Carbon;
class TransactionController extends Controller
{
   public function index(Request $request)
   {
       $memberid = $request->get('member_id');
       $trans = Transaction::where(['member_id' => $memberid])->orderBy('created_at','DESC')->get();
       $dt = array();
       foreach($trans as $tr){
           $tr->packageprice;
           $tr->promo;
           $dt[] = $tr;
       }
        return Response::json(['list'=>$dt],200);
   }
   
   public function addtrans(Request $request){
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
       
        $transaksi->save();
   }
   
}
