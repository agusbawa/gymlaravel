<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymUserTable extends Migration {

	public function up()
	{
		Schema::create('gym_user', function(Blueprint $table) {
			$table->bigInteger('gym_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('gym_user');
	}
}