<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\RegymEloquentTrait;

class Personaltrainer extends Model {

	protected $table = 'personal_trainer';
	public $timestamps = true;

	use Notifiable;
	use SoftDeletes;
	use RegymEloquentTrait;

	protected $dates = ['deleted_at','expired_at','tgl_bayar'];

	public function gym()
	{
		return $this->belongsTo('App\Gym');
	}
	public function member()
	{
		return $this->belongsTo('App\Member');
	}
}