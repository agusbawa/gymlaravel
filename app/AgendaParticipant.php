<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaParticipant extends Model {

	protected $table = 'agenda_participant';
	public $timestamps = true;

	public function agenda()
	{
		return $this->belongsTo('App\Agenda');
	}

}