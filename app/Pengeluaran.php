<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\RegymEloquentTrait;

class Pengeluaran extends Model {

	protected $table = 'pengeluaran';
	public $timestamps = true;

	use Notifiable;
	use SoftDeletes;
	use RegymEloquentTrait;

	protected $dates = ['deleted_at','expired_at','tgl_keluar'];

	public function gym()
	{
		return $this->belongsTo('App\Gym');
	}

}