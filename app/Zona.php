<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Traits\RegymEloquentTrait;

class Zona extends Authenticatable
{
    use RegymEloquentTrait;

    protected $table = 'zonas';

    public function gyms()
    {
        return $this->hasMany('App\Gym');
    }
}
