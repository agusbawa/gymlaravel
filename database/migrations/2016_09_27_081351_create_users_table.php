<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name', 100);
			$table->string('username', 30);
			$table->string('email', 100);
			$table->string('password', 100);
			$table->string('phone', 15);
			$table->string('remember_token', 100);
			$table->string('avatar');
			$table->softDeletes();
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}