<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trialmember extends Model {

	protected $table = 'trial_member';
	public $timestamps = true;
	use SoftDeletes;
	use Notifiable;
	use RegymEloquentTrait;

	protected $dates = ['date_of_birth','folow_up','tanggal_kedatangan'];

	public function gym()
	{
		return $this->belongsTo('App\Gym');
	}

	
}