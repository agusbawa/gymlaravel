<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GymEmail extends Model
{
    //
    protected $table = "gym_email";

    public function listemail ($value='')
    {
        return $this->belongsTo('App/ListEmail');
    }
}
