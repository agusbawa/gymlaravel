<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberListEmail extends Model
{
    //
    protected $table = "member_list_email";
    public $timestamps = false;

    public function listemail()
    {
        return $this->belongsTo('App\ListEmail');
    }
}
