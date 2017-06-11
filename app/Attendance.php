<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {

	protected $table = 'attendances';
	public $timestamps = true;
	protected $dates = ['check_in','check_out'];

	public function gym()
	{
		return $this->belongsTo('App\Gym');
	}

	public function member()
	{
		return $this->belongsTo('App\Member');
	}

}