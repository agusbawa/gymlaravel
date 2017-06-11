<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;
class ListMenu extends Model
{
    //
    protected $fillable = ['title'];
    public $timestamps = true;

   /* use Notifiable;
	use RegymEloquentTrait;*/
    public function permissionRole()
	{
		return $this->hasMany('App\PermissionRole');
	}
}

