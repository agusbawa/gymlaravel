<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class Agenda extends Model {
	use RegymEloquentTrait;
	protected $table = 'agendas';
	public $timestamps = true;

	public function participants()
	{
		return $this->hasMany('App\AgendaParticipant');
	}

}