<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class Card extends Model {
	use RegymEloquentTrait;
	protected $table = 'cards';
	public $timestamps = true;

	public function member()
	{
		return $this->belongsToMany('App\Member','card_member');
	}

	// public static function availableCard()
	// {
	// 	$card 	=	new self;
	// 	return $card->whereHas('member',function($query){},0);
	// }
}