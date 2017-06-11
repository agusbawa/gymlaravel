<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardMember extends Model
{
    //
    protected $table = 'card_member';
	public $timestamps = true;

    public function member()
	{
		return $this->belongsTo('App\Member');
	}
}
