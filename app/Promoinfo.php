<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class Promoinfo extends Model {

	protected $table = 'promo_info';
	public $timestamps = true;

	use Notifiable;
	use RegymEloquentTrait;

	protected $dates = ['harimulai','hariakhir'];

	

	
}