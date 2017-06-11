<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class News extends Model
{
    use RegymEloquentTrait;
    protected $table = 'news';
}
