<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZonaEmail extends Model
{
    //
    protected $table = "zona_email";

    public function listemail ()
    {
        return $this->belongsTo('App/ListEmail');
    }
}
