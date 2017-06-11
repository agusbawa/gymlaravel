<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class Role extends Model {

	protected $table = 'roles';
	public $timestamps = false;
	use RegymEloquentTrait;

	public function permissionRole()
	{
		return $this->hasMany('App\PermissionRole');
	}

	public function permission()
	{
		return $this->belongsToMany('App\Permission');
	}

	public function users()
	{
		return $this->hasMany('App\User','role_id');
	}

}