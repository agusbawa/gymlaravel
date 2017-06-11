<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TiketSupport extends Model
{
    //
    protected $table = 'tiket_supports';
    public $timestamps = true;
    use SoftDeletes;
    protected $date = ['created_at'];
    public function member()
    {
        # code...
        return $this->belongsTo('App\Member');
    }

    public function tiketmsg()
    {
        # code...
        return $this->hasMany('App\TiketMessage');
    }
}
