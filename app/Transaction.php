<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;
use App\PackagePrice;
use App\Promo;
use App\Gym;
use Carbon\Carbon;
class Transaction extends Model {
	use RegymEloquentTrait;

	protected $table = 'transactions';
	public $timestamps = true;

	public function gym(){
		return $this->belongsTo('App\Gym','gym_id','id');
	}

	public function packageprice(){
		return $this->belongsTo('App\PackagePrice','package_price_id','id');
	}

	public function member(){
		return $this->belongsTo('App\Member','member_id','id');
	}
	public function promo(){
		return $this->belongsTo('App\Promo','promo_id','id');
	}
	public function paymentMethod()
	{
		return $this->belongsTo('App\TrasactionPayment','transaction_id');
	}
	public function FunctionName($value='')
	{
		# code...
	}
	public static function validasi($idpaket,$idpromo=null)
	{
		if(!is_null($idpromo)){
			$package = PackagePrice::findOrFail($idpaket);
			$getpromo = Promo::find($idpromo);
			if(is_null($package->promo()->where('promo_id',$idpromo)->get())){
				return false;
			}else{
				if($getpromo->start_date <= Carbon::now() && $getpromo->end_date >= Carbon::now()){
					if($getpromo->qty > 0){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
					
			}
		}else{
			return true;
		}

	}
	public static function gymreport($id)
	{
		
		$pendapatan = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->where('members.gym_id',$id);
        $total = 0;
		dd($pendapatan->get());
        foreach($pendapatan->get() as $trans){
            $total = $total+$trans->total;
        }
        
        
        $baru = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $newtotal = 0;
         
        $newsatu =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $newtiga =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        foreach($baru->select('transactions.total')->get() as $new){
            $newtotal = $newtotal + $new->total;
        }
       
       
       $totalnewsatu = 0;
        foreach($newsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('package_prices.price')->get() as $new){
            $totalnewsatu = $totalnewsatu + $new->price;
        }
        
         
        $totalnewtiga = 0;
        foreach($newtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('package_prices.price')->get() as $new){
            $totalnewtiga = $totalnewtiga + $new->price;
        }
       
        $newempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewempat = 0;
        foreach($newempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
            $totalnewempat = $totalnewempat + $new->price;
        }
        $newlima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewlima = 0;
        foreach($newlima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
            $totalnewlima = $totalnewlima + $new->price;
        }
//------------------------------------------------------------
        $panjang = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
       
        $totalpanjang = 0;
        $panjangsatu =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $panjangtiga =  Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        foreach($panjang->select('transactions.total')->get() as $new){
            $totalpanjang = $totalpanjang + $new->total;
        }
       
       
       $totalpanjangsatu = 0;
        foreach($panjangsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('package_prices.price')->get() as $new){
            $totalpanjangsatu = $totalpanjangsatu + $new->price;
        }
        
         
        $totalpanjangtiga = 0;
        foreach($panjangtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('package_prices.price')->get() as $new){
            $totalpanjangtiga = $totalpanjangtiga + $new->price;
        }
       
        $panjangempat = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjangempat = 0;
        foreach($panjangempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
            $totalpanjangempat = $totalpanjangempat + $new->price;
        }
        $panjanglima = Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjanglima = 0;
        foreach($panjanglima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('package_prices.price')->get() as $new){
            $totalpanjanglima = $totalpanjanglima + $new->price;
        }
        $memberharian = Memberharian::orderBy('members_harian.id','asc')->join('package_prices','package_prices.id','=','members_harian.package_id')->get();
        $totalharian = 0;
        foreach($memberharian as $harian){
            $totalharian = $totalharian + $harian->price;
        }
        $kantin = Kantin::orderBy('kantin.id','asc')->get();
        $totalkantin = 0;
        foreach($kantin as $harian){
            $totalkantin = $totalkantin + $harian->total;
        }
        $personaltrainer = Personaltrainer::orderBy('id','asc')->get();
        $totaltrainer = 0;
        foreach($personaltrainer as $harian){
            $totaltrainer = $totaltrainer + $harian->fee_gym;
        }
        $total = $total + $totalharian + $totalkantin +  $totaltrainer;
        $gym =Gym::get();
        $zona = Zona::get();
            $tertentugym = array();
            $tertentuzona = array();
            $tertentugymku = array();
			
           return $total;
	}

}