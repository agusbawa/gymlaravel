<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\RegymEloquentTrait;

class Memberharian extends Model {

	protected $table = 'members_harian';
	public $timestamps = true;

	use Notifiable;
	use SoftDeletes;
	use RegymEloquentTrait;

	protected $dates = ['deleted_at','expired_at','tgl_bayar'];

	public function gym()
	{
		return $this->belongsTo('App\Gym');
	}

	public function package_price()
	{
            return $this->belongsTo('App\PackagePrice', 'package_id','id');
	}

}