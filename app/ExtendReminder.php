<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtendReminder extends Model {

	protected $table = 'extend_reminder';
	public $timestamps = false;

	public function member()
	{
		return $this->belongsTo('App\Members');
	}

}