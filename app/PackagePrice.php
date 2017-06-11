<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class PackagePrice extends Model {

	protected $table = 'package_prices';
	public $timestamps = false;
	use RegymEloquentTrait;

	public function package()
	{
		return $this->belongsTo('App\Package','package_id');
	}
	public function transactions()
	{
		return $this->hasMany('App\Transaction');
	}
	public function promo()
	{
		return $this->belongsToMany('App\Promo');
	}
}