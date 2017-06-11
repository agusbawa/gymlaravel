<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\RegymEloquentTrait;

class Member extends Model {

	protected $table = 'members';
	public $timestamps = true;

	use Notifiable;
	use SoftDeletes;
	use RegymEloquentTrait;

	protected $dates = ['deleted_at','expired_at','date_of_birth'];

	public function gym()
	{
		return $this->belongsTo('App\Gym');
	}

	public function aktifasi(){
		return $this->hasOne('App\Aktifasi');
	}

	public function package()
	{
		return $this->hasOne('App\Package');
	}

	public function card()
	{
		return $this->belongsToMany('App\Card','card_member');
	}

	public function attendances()
	{
		return $this->hasMany('App\Attendance');
	}

	public function memberVote()
	{
		return $this->hasMany('App\MemberVote');
	}

	public function extendReminder()
	{
		return $this->hasMany('App\ExtendReminder');
	}

	public function transactions()
	{
		return $this->hasMany('App\Transaction','member_id');
	}

	public function memberHistories()
	{
		return $this->hasMany('App\MemberHistory','member_id');
	}
	 public function listemail()
    {
        # code...
        return $this->belongsToMany('App\ListEmail');
    }

	public function processAttendance($gym_id, $timestamp = false)
	{
		$timestamp 			=	($timestamp)?\Carbon\Carbon::createFromTimeStamp(strtotime($timestamp)) : \Carbon\Carbon::now();
		$todayAttendace 	= 	$this->attendances()->whereDate('created_at','=' , $timestamp->format("Y-m-d"));
		if ($todayAttendace->count() == 0 || $todayAttendace->orderBy('created_at','desc')->first()->check_in != $todayAttendace->orderBy('created_at','desc')->first()->check_out) {
			$this->checkIn($gym_id, $timestamp);
			return "Check In";
		}
		else
		{
			//if($todayAttendace->first()->check_in != $todayAttendace->first()->check_out){
				//$this->checkIn($gym_id, $timestamp);
				//return "Check In";
			//}else{
				$this->checkOut($gym_id, $timestamp);
				return "Check Out";
			//}
		}
	}

	public function checkIn($gym_id, $timestamp)
	{
		//$todayAttendace 	=	$this->attendances()->whereDate('created_at','=' ,$timestamp->format("Y-m-d"));
		
		/*if($todayAttendace->count() > 0)
		{
			$attendances 				=	$todayAttendace->first();
			$attendances->gym_id 		=	$gym_id;
			$attendances->member_id 	=	$this->id;
			$attendances->check_in 		=	$timestamp;
			$attendances->check_out		=	$timestamp;
			$attendances->save();
		}
		else
		{*/
			$attendances 				=	new \App\Attendance;
			$attendances->gym_id 		=	$gym_id;
			$attendances->member_id 	=	$this->id;
			$attendances->check_in 		=	$timestamp;
			$attendances->check_out		=	$timestamp;
			$attendances->created_at	=	$timestamp;
			$attendances->save();
	//	}

		request()->session()->flash('alert-success', 'Check In Berhasil');

		return true;
	}

	/**
	 * [checkOut description]
	 * @param  [type] $gym_id    [description]
	 * @param  [type] $timestamp [description]
	 * @return [type]            [description]
	 */
	public function checkOut($gym_id, $timestamp)
	{
		$todayAttendace 	=	$this->attendances()->orderBy('created_at','desc')->whereDate('created_at', $timestamp->format("Y-m-d"));
		//if($todayAttendace->count() > 0)
		//{
			$attendances 				=	$todayAttendace->first();
			$attendances->gym_id 		=	$gym_id;
			$attendances->member_id 	=	$this->id;
			$attendances->check_out		=	$timestamp;
			$attendances->save();
	//	}
	//	else
	/*	{
			$attendances 				=	new \App\Attendance;
			$attendances->gym_id 		=	$gym_id;
			$attendances->member_id 	=	$this->id;
			$attendances->check_in		=	$timestamp;
			$attendances->check_out		=	$timestamp;
			$attendances->created_at	=	$timestamp;
			$attendances->save();
		}*/

		request()->session()->flash('alert-success', 'Check Out Berhasil');

		return true;
	}
	public static function to_image( $base64_string, $output_file ) {
     // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 
}
	
}