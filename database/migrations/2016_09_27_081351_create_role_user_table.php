<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUserTable extends Migration {

	public function up()
	{
		Schema::create('role_user', function(Blueprint $table) {
			$table->bigInteger('role_id')->unsigned();
			$table->bigInteger('user_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('role_user');
	}
}