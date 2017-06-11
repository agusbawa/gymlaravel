<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\RegymEloquentTrait;
use Carbon\Carbon;
class MemberHistory extends Model
{
    //
    protected $table = 'member_histories';
	public $timestamps = true;

	use Notifiable;
	
	use RegymEloquentTrait;

	public function member(){
		return $this->belongsTo('App/Member','member_id');
	}
	public function packagePrice(){
		return $this->belongsTo('App/PackagePrice','package_price_id','id');
	}
	public function gym(){
		return $this->belongsTo('App/gym','gym_id','id');
	}

	public static function DataAktifasiMasuk($id_member,$id_gym,$id_package,$expired,$promo_id=null,$stat){
		$current = Carbon::now();
		
		//$paket = \App\PackagePrice::find($id_package);
		
		//$expired = \Carbon\Carbon::now()->addDays($packagePrice->day);
		$history            			= new \App\MemberHistory;
		$history->member_id				= $id_member;
		$history->gym_id				= $id_gym;
		$history->package_price_id		= $id_package;
		if($promo_id == null){
			$history->promo_id = '0';
		}else{
		$history->promo_id 				= $promo_id;
		}
		if($stat == 'extend'){
			$history->new_register			= null;
			$history->extends 				= $current;
		}else{
			
			$history->new_register			= $current;
			$history->extends 				=null;
		}
		
		$history->expired				= $expired;
		$history->save();
		request()->session()->flash('alert-success', 'Aktifasi sudah tercatat');

        return true;
	}
}
