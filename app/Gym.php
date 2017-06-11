<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;
use Carbon\Carbon; 

class Gym extends Model {
	use RegymEloquentTrait;

	protected $table = 'gyms';
	public $timestamps = true;

	public function setoran()
	{
		# code...
		return $this->hasMany('App\Setoranbank','gym_id');
	}
	public function package()
	{
		return $this->belongsTo('App\Package','package_id');
	}
	public function users()
	{
		return $this->belongsToMany('App\User');
	}
    public function zona()
	{
		# code...
		return $this->belongsTo('App\Zona');
	}
	public function members()
	{
		return $this->hasMany('App\Member');
	}
	public function transactions()
	{
		return $this->hasMany('App\Transaction');
	}
	public function attendances()
	{
		return $this->hasMany('App\Attendance');
	}
	public function memberHistories()
	{
		return $this->hasMany('App\MemberHistory');
	}
	public function memberGrowth()
	{
		$members 	=	$this->members();		
		$members->select([
		\DB::raw("DATE_FORMAT(created_at, '%c') AS `month`"),
		\DB::raw('COUNT(id) AS count'),
		])
		->whereYear('created_at','=',date('Y'))
		->groupBy('month')
		->orderBy('month', 'ASC')
		->get();

		$result = array();
		for ($i = 1; $i <= 12; $i++) {
    		$result[$i] 	=	"[(new Date('".date("Y")."/".$i."/1')).getTime() ,0]";
		}

		foreach($members->get() as $member){
			$result[$member->month] 	=	"[(new Date('".date("Y")."/".$member->month."/1')).getTime() ,".$member->count."]";
		}		
		$result 	=	"[".implode(",", $result)."]";
		return $result;
	}

	

}