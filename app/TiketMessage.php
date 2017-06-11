<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TiketMessage extends Model
{
    //
    //
    protected $table = 'tiket_msgs';
    public $timestamps = true;
    use SoftDeletes;
    protected $date = ['created_at'];


    public function tiketsupport()
    {
        # code...
        return $this->belongsTo('App\TiketSupport');
    }
}
