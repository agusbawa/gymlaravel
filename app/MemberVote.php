<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberVote extends Model {

	protected $table = 'member_vote';
	public $timestamps = true;

	public function voteItem()
	{
		return $this->belongsTo('App\VoteItem');
	}

	public function member()
	{
		return $this->belongsTo('App\Members');
	}

}