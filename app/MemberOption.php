<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class MemberOption extends Model {

	protected $table = 'member_options';

	protected $dates = ['deleted_at','expired_at','date_of_birth'];
}