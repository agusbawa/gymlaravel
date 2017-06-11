<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

	protected $table = 'permissions';
	public $timestamps = false;

	public function roles()
	{
		return $this->belongsToMany('App\Role');
	}
	public function list_menu()
	{
		return $this->belongsToMany('App\list_menu');
	}
	public function PermissionRole()
	{
		return $this->hasMany('App\PermissionRole');
	}
		public static function IdUser(){
			return Auth::user()->role_id;
		}
	Public static function MenuRole($id_user,$id_permission,$id_parrent){
		$id_menu = \App\PermissionRole::where('role_id','=',$id_user)->where('permission_id',$id_permission)->first();
		if(is_null($id_menu)){
			return 'kosong';
		}else{
			$subparrent = self::findOrFail($id_permission);
			
			if($subparrent->parent == $id_parrent){
				return 1;
			}else{
				return 0;
			}
			
		}
	}
	Public static function IdMenu($id_menu){
		$menu = \App\Permission::find($id_menu);
		return $menu;
	}
	Public static function SubMenu($id_menu,$id_role){
		$submenu = \App\PermissionRole::where('permission_id','=',$id_menu)->where('role_id',$id_role)->first();
		if($submenu == null){
			return 0;
		}else if($submenu->lihat == 0){
			return 0;
		}else{
		return 1;
		}
	}
	Public static function CreatePer($id_menu,$id_role){
		$submenu = \App\PermissionRole::where('permission_id','=',$id_menu)->where('role_id',$id_role)->first();
		if($submenu == null){
			return 0;
		}else if($submenu->create == 0){
			return 0;
		}else{
		return 1;
		}
	}
	Public static function EditPer($id_menu,$id_role){
		$submenu = \App\PermissionRole::where('permission_id','=',$id_menu)->where('role_id',$id_role)->first();
		if($submenu == null){
			return 0;
		}else if($submenu->update == 0){
			return 0;
		}else{
		return 1;
		}
	}
	Public static function DeletePer($id_menu,$id_role){
		$submenu = \App\PermissionRole::where('permission_id','=',$id_menu)->where('role_id',$id_role)->first();
		if($submenu == null){
			return 0;
		}else if($submenu->delete == 0){
			return 0;
		}else{
		return 1;
		}
	}
	public static function CheckGym($iduser)
	{
		$access = \App\GymUser::where('user_id',$iduser)->first();
		if(is_null($access)){
			return 0;
		}else{
			
			return 1;
		}
	}
	public static function GymAccess($iduser,$idgym)
	{
		$access = \App\GymUser::where('user_id',$iduser)->where('gym_id',$idgym)->first();
		
		if(is_null($access)){
			return 0;
		}else{
			return 1;
		}
	}
	public static function CheckZona($iduser)
	{
		$access = \App\ZonaUser::where('user_id',$iduser)->first();
		if(is_null($access)){
			return 0;
		}else{
			
			return 1;
		}
	}
	public static function ZonaAccess($iduser,$idzona)
	{
		$access = \App\ZonaUser::where('user_id',$iduser)->where('zona_id',$idzona)->first();
		
		if(is_null($access)){
			return 0;
		}else{
			return 1;
		}
	}
}