<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\RegymEloquentTrait;

class Pettycash extends Model {

	protected $table = 'petty_cash';
	public $timestamps = true;

	use Notifiable;
	use SoftDeletes;
	use RegymEloquentTrait;

	protected $dates = ['deleted_at','expired_at','tanggal_petty'];

	public function gym()
	{
		return $this->belongsTo('App\Gym');
	}

}