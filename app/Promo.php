<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\RegymEloquentTrait;
use App\PromoPackage;
use Carbon\Carbon;
class Promo extends Model {

	protected $table 	= 'promos';
	public $timestamps 	= true;

	use SoftDeletes;
	use RegymEloquentTrait;

	protected $dates = ['deleted_at','start_date','end_date'];

	public function package()
	{
		return $this->belongsToMany('App\PackagePrice');
	}
	public function transaksi()
	{
		return $this->hasMany('App\Transaction');
	}
	public static function isValid($code)
	{
		$self 	=	Promo::where('code','=', $code)->where('end_date','>=',date('Y-m-d'))->where('start_date','<=',date('Y-m-d'))->first();
		if (is_null($self)) {
			return "dor";
		}else{
		// dd($self);
		
		// dd(($self->qty < 1 || $self->is_enabled	== 0 || $self->start_date >= date("Y-m-d H:i:s") || $self->end_date <= date("Y-m-d H:i:s")))
		
				if($self->qty > 0){
					return $self;
				}else{
					return "salah";
				}
			
				return false;
			}

		
	}
	public static function backValid($idpromo,$idpaket)
	{
		$paketpromo = PromoPackage::where('promo_id',$idpromo)->where('package_price_id',$idpaket)->first();
	
		if(is_null($paketpromo)){
			return false;
		}else{
			$promo = Promo::find($idpromo);
			
			if($promo->end_date >= Carbon::now() && $promo->start_date <= Carbon::now()){
				
				if($promo->qty > 0){
					
					return true;
				}else{
					
					return false;
				}				
			}else{
				return false;
			}
		}
	}
	public static function frontValid($codepromo,$idpaket)
	{
		$promo = Promo::where('code',$codepromo)->first();
		$paketpromo = PromoPackage::where('promo_id',$promo->id)->where('package_price_id',$idpaket)->first();
	
		if(is_null($paketpromo)){
			return false;
		}else{
			
			
			if($promo->end_date >= Carbon::now() && $promo->start_date <= Carbon::now()){
				
				if($promo->qty > 0){
					
					return true;
				}else{
					
					return false;
				}				
			}else{
				return false;
			}
		}
	}
}