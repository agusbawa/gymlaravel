<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration {

	public function up()
	{
		Schema::create('attendances', function(Blueprint $table) {
			$table->increments('id');
			$table->bigInteger('gym_id')->unsigned();
			$table->bigInteger('member_id')->unsigned();
			$table->datetime('check_in');
			$table->datetime('check_out');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('attendances');
	}
}