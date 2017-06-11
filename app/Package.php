<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model {

	protected $table = 'packages';
	public $timestamps = true;
	use RegymEloquentTrait;
	use SoftDeletes;

	public function packagePrice()
	{
		return $this->hasMany('App\PackagePrice');
	}
	public function gyms()
	{
		# code...
		return $this->hasMany('App\Gym');
	}
	public function findPackagePrice($id){
		$value = packagePrice()->find($id)->select('price')->first();
		return $value;
	}

}