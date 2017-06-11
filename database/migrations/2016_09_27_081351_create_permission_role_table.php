<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoleTable extends Migration {

	public function up()
	{
		Schema::create('permission_role', function(Blueprint $table) {
			$table->bigInteger('permission_id')->unsigned();
			$table->bigInteger('role_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('permission_role');
	}
}