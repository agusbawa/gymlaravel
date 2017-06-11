<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListEmail extends Model
{
    //
     protected $table = "list_emails";
    public $timestamps = true;

    public function members()
    {
        # code...
        return $this->HasMany('App\MemberListEmail');
    }
   
}
