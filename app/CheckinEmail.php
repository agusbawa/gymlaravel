<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckinEmail extends Model
{
    //
    protected $table = "checkin_email";

    public function listemail ($value='')
    {
        return $this->belongsTo('App/ListEmail');
    }
}
