<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\MemberHistory;
use App\Member;
use App\Package;
use App\Promo;
use App\PackagePrice;
use App\Transaction;
use App\TrasactionPayment;
use Carbon\Carbon;
use App\Aktifasi;
use App\User;
use App\GymUser;
use Mail;
use App\Mail\MailAktifasi;
class MemberController extends Controller
{
    public function index(){
    	return Response::json(['text'=>'hai'],200);
    }
    public function oldmember(Request $request){
        $idMember = $request->get('idoldmember');
        $idGym = $request->get('gymcenter');
        
         dd($promo);
        if(!empty($idMember) && !empty($idGym)){
            $data = Member::where(array('slug' => $idMember,'gym_id' => $idGym))->first();
            if(!empty($data)){
                return Response::json(['sts'=>'ok','data'=>$data],200);
            }else{
                return Response::json(['sts'=>'error'],200);
            }
            
        }else{
            return Response::json(['sts'=>'error'],200);
        }
    }
    
    public function getMember(Request $request){
        $idMember = $request->get('member_id');
        
        $data = Member::where(array('id' => $idMember))->first();
        $data->gym;
        return Response::json(['sts'=>'ok','data'=>$data],200);
    }
    
    public function memberupdate(Request $request){
        $member                 =   Member::findOrFail($request->get('member_id'));
        $member->name           =   $request->get('name');
        $member->nick_name      =   $request->get('nick_name');
        $member->address_street =   $request->get('address_street');
        $member->address_region =   $request->get('address_region');
        $member->address_city   =   $request->get('address_city');
        $member->phone          =   $request->get('phone');
        $member->facebook_url   =   $request->get('facebook_url');
        $member->twitter_url    =   $request->get('twitter_url');
        $member->instagram_url  =   $request->get('instagram_url');
        $member->hobby          =   $request->get('hobby');
        $member->job            =   $request->get('job');
        $password = $request->get('password');
        if(!empty($password)){
            try {
                if(decrypt($member->password)!=decrypt($request->get('password')))
                {
                    $member->password   =   encrypt($request->get('password'));
                }
            } catch (\Exception $e) {
                $member->password   =   encrypt($request->get('password'));
            }
        }
        

        $member->gender         =   $request->get('gender');
        $member->place_of_birth =   $request->get('place_of_birth');
        $member->date_of_birth  =   date('Y-m-d',strtotime($request->get('date_of_birth')));

        
        $member->save();
        
        return Response::json(['sts'=>'ok'],200);
    }
    
    public function orderpackage(Request $request){        
        
        $price = PackagePrice::find($request->get('package_id'))->first();
        $transaksi = new Transaction;
        $transaksi->member_id = $request->get('member_id');
        $transaksi->gym_id = $request->get('gym_id');
        $transaksi->package_price_id = $price->id;
        $transaksi->code = str_random(8);
            if(!empty($request->get('promo'))){
            $promo = Promo::findOrFail($request->get('promo'));
            $transaksi->promo_id = $request->get('promo');
            
            $promoDiscount = Promo::find($request->get('promo'));
                if($promoDiscount->unit == "PERCENTAGE"){
                $total = $price->price - ($price->price * ($promoDiscount->value / 100));
                }
                else if($promoDiscount->unit == "NOMINAL"){
                    $total = $price->price - $promoDiscount->value;
                }else{
                $total = $price->price;
            }
            $promo->qty = $promo->qty - 1;
            $promo->save();
        }else{
            $transaksi->promo_id = '0';
            $total = $price->price;
        }

        
        $transaksi->total = $total;
        $transaksi->payment_method = $request->get('payment_by');
        $transaksi->status="Pending";
        $transaksi->save();

       $paymenttransaksi = new TrasactionPayment;
       $paymenttransaksi->transaction_id = $transaksi->id;
       $paymenttransaksi->pacakge_price_id = $price->id;
       if(!empty($request->get('promo'))){
       $paymenttransaksi->promo_id =  $request->get('promo');
       
       }else{
           $paymenttransaksi->promo_id = '0';
       }
       
        $paymenttransaksi->refrences_payment = ' - ';
        $paymenttransaksi->payment_method = $request->get('payment_by');
       $paymenttransaksi->save();
        
        
        
        $return = array(
            'id_transaksi'=>$transaksi->id,
            'id_payment' => $paymenttransaksi->id,
            'package_detail'=>$price->title,
            'harga'=>$total,
            'payment' => $request->get('payment_by'),
            );
        
        return Response::json(['sts'=>$return],200);
    }
    
    public function register(Request $request){
        $member                 =   new Member;
        $member->name           =   $request->get('name');
        $member->slug           =   "";
        $member->nick_name      =   $request->get('nick_name');
        $member->address_street =   $request->get('address_street');
        $member->address_region =   $request->get('address_region');
        $member->address_city   =   $request->get('address_city');
        $member->phone          =   $request->get('phone');
        $member->email          =   $request->get('email');
        $member->hobby          =   $request->get('hobby');
        $member->job            =   $request->get('job');
        $member->gym_id         =   $request->get('gym_id');
        $member->gender         =   $request->get('gender');
        $member->place_of_birth =   $request->get('place_of_birth');
        $member->date_of_birth  =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        $member->password       =   encrypt(str_random(8));
        $member->status         =   'INACTIVE';
        $member->package_id     =   $request->get('package_id');
        $member->registerfrom = '1';
        $member->type = 'New';
        $member->save();
//        $data = PackagePrice::where('id',$request->get('package_id'))->first();
        $email = Member::where('email','=',$request->get('email'))->first();
        if($email == null){
             return Response::json(['sts'=>'email'],200);
        }
        $price = PackagePrice::find($request->get('package_id'))->first();
        $transaksi = new Transaction;
        $transaksi->member_id = $member->id;
        $transaksi->gym_id = $request->get('gym_id');
        $transaksi->package_price_id = $price->id;
        $transaksi->code = str_random(8);
            if(!empty($request->get('promo'))){
            $promo = Promo::findOrFail($request->get('promo'));
            $transaksi->promo_id = $request->get('promo');
            
            $promoDiscount = Promo::find($request->get('promo'));
                if($promoDiscount->unit == "PERCENTAGE"){
                $total = $price->price - ($price->price * ($promoDiscount->value / 100));
                }
                else if($promoDiscount->unit == "NOMINAL"){
                    $total = $price->price - $promoDiscount->value;
                }else{
                $total = $price->price;
            }
            $promo->qty = $promo->qty - 1;
            $promo->save();
        }else{
            $transaksi->promo_id = '0';
            $total = $price->price;
        }

        
        $transaksi->total = $total;
        //$transaksi->payment_method = $request->get('payment_by');
        $transaksi->status="Pending";
        $transaksi->save();

       $paymenttransaksi = new TrasactionPayment;
       $paymenttransaksi->transaction_id = $transaksi->id;
       $paymenttransaksi->pacakge_price_id = $price->id;
       if(!empty($request->get('promo'))){
       $paymenttransaksi->promo_id =  $request->get('promo');
       
       }else{
           $paymenttransaksi->promo_id = '0';
       }
       
        $paymenttransaksi->refrences_payment = ' - ';
        $paymenttransaksi->payment_method = $request->get('payment_by');
       $paymenttransaksi->save();
       
     $aktifasi = new Aktifasi;
     $aktifasi->member_id = $member->id;
     $aktifasi->code = str_random(4);
     $aktifasi->type = 'New';
     $aktifasi->gym_id = $request->get('gym_id');
     $aktifasi->package_price_id = $request->get('package_id');
     $aktifasi->trasaction_id = $transaksi->id;
     $aktifasi->expire = Carbon::now()->addMonths(3);
     $aktifasi->save();
     Mail::to($member->email)->send(new MailAktifasi($aktifasi->code));
     $users = User::orderBy('id','desc')->get();
     foreach($users as $user){
         $gymusers = GymUser::where('user_id',$user->id)->where('gym_id',$request->get('gym_id'))->get();
         foreach($gymusers as $gymuser){
             Mail::to($user->email)->send(new mailCreatedCs($email,$pass));
         }
     }
    

        
//        $trans = new Transaction;
//        $trans->gym_id = $request->get('gym_id');
//        $trans->package_price_id = $request->get('package_id');
//        $trans->member_id = $member->id;
//        $trans->status = 'inactive';
//        $trans->save();
        
       
        $return = array(
            'id_transaksi'=>$transaksi->id,
            'id_payment' => $paymenttransaksi->id,
            'package_detail'=>$price->title,
            'harga'=>$total,
            'payment' => $request->get('payment_by'),
            );
        
        return Response::json(['sts'=>$return],200);
    }
    
    public function tambahmember(Request $request){
        $member                 =   new Member;
        $member->name           =   $request->get('name');
        $member->slug           =   ($request->get('slugcheck'))?$request->get('slug'):"";
        $member->nick_name      =   $request->get('nick_name');
        $member->address_street =   $request->get('address_street');
        $member->address_region =   $request->get('address_region');
        $member->address_city   =   $request->get('address_city');
        $member->phone          =   $request->get('phone');
        $member->email          =   $request->get('email');
        $member->facebook_url   =   $request->get('facebook_url');
        $member->twitter_url    =   $request->get('twitter_url');
        $member->instagram_url  =   $request->get('instagram_url');
        $member->hobby          =   $request->get('hobby');
        $member->job            =   $request->get('job');
        $member->gym_id         =   $request->get('gym_id');
        $member->gender         =   $request->get('gender');
        $member->place_of_birth =   $request->get('place_of_birth');
        $member->date_of_birth  =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        $member->password       =   encrypt(str_random(8));
        $member->status         =   $request->get('status');
        $member->package_id     =   \App\Package::first()->id;
        $member->extended_at    =   date("Y-m-d");
        $member->expired_at    =   date("Y-m-d");
        $member->registerfrom = $request->get('registerfrom');
        $member->save();
    }
    public function contohPost(Request $request){
        $code               = new MemberHistory;
        $code->member_id    = $request->get('member');
       
        $code->gym_id       = $request->get('gym');
        $expired = date( 'Y-m-d H:i:s', strtotime( '+30 day' ) );
        $current = Carbon::now();
         $code->new_register = $current;
         $code->package_price_id = $request->get('package');
        $code->extends 				= $current;
        $code->expired				= $expired;
        $code->save();
        if($code == null){
            return Response::json(['Error'=>'Error while compile a massage'],200);
        }else{
            return Response::json(['Success'=>'Request is successfuly'],200);
        }
    }
    public function login(Request $request){
        
        $email = $request->get('email');
        $password = $request->get('password');
        $data = Member::where('email',$email)->first();
        if(!empty($email) && !empty($password)){
            if(decrypt($data->password) == $password){
                return Response::json(['sts'=>'ok','data' => $data],200);
            }else{
                return Response::json(['sts'=>'error'],200);
            }
        }else{
            return Response::json(['sts'=>'error'],200);
        }
        
        
        
    }
    
    public function promocode(Request $request){
        if(Promo::frontValid($request->get('promocode'), $request->get('packageid'))){
            $getPromo = Promo::where('code','=', $request->get('promocode'))->first();
            if($getPromo != null){
                $price = PackagePrice::where('id','=',$request->get('packageid'))->first();
                if($price != null){
                    $priceold = $price->price;
                    
                    if($getPromo->unit == 'PERCENTAGE'){
                        $discount = ($priceold * $getPromo->value) / 100;
                        $discount = floor($discount);
                    }else{
                        $discount = $getPromo->value;
                    }
                    
                    $data = array(
                        'normal' => number_format($priceold,2,',','.'),
                        'pricediscount' => number_format($priceold - $discount,2,',','.'),
                        'discount' => number_format($discount,2,',','.'),
                        'promoid' => $getPromo->id
                    );
                    
                    return Response::json(['sts'=>'ok', 'data' => $data],200); 
                    
                }else{
                    return Response::json(['sts'=>'error'],200); 
                }
            }
        }else{
           return Response::json(['sts'=>'error 1'],200); 
        }
    }
    
}
