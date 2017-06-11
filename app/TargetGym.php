<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;
class TargetGym extends Model
{
    //
    protected $table = 'target_gym';
    public $timestamps = true;
    use RegymEloquentTrait;
    public function gym()
    {
        # code...
        return $this->belongsTo('App\Gym');
    }

    public function personalTrainer()
    {
        # code...
        return $this->belongsTo('App\Personaltrainer');
    }
}
