<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class Aktifasi extends Model
{
	use RegymEloquentTrait;
	public $timestamps = true;
    //
    Protected $table = 'aktifasis';

    public function member(){
    	return $this->belongsTo('App\Member','member_id','id');
    }
    public function packagePrice(){
    	return $this->belongsTo('App\PackagePrice','package_price_id','id');
    }
}
