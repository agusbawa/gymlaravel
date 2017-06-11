<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {

	protected $table = 'permission_role';
	public $timestamps = false;

	public function role()
	{
		return $this->belongsToMany('App\Role','role_id','id');
	}

	public function permission()
	{
		return $this->belongsToMany('App\Permission','permission_id','id');
	}
}