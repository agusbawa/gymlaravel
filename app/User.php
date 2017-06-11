<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use App\Http\Traits\RegymEloquentTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use RegymEloquentTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   // public function getAvatarAttribute($avatar)
 //   {
       // return url('public'."/ imgaes /".$avatar);
    //}

    public function role()
	{
		return $this->belongsTo('App\Role','role_id');
	}

	public function gyms()
	{
		return $this->belongsToMany('App\Gym');
	}
    public function zonas()
    {
        return $this->belongsToMany('App\Zona');
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
}
