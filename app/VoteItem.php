<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteItem extends Model {

	protected $table = 'vote_items';
	public $timestamps = true;

	public function vote()
	{
		return $this->belongsTo('App\Vote');
	}

	public function memberVotes()
	{
		return $this->hasMany('App\MemberVote');
	}

}