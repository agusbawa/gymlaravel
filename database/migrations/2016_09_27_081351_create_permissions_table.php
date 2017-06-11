<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration {

	public function up()
	{
		Schema::create('permissions', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name', 100);
			$table->string('route', 100);
		});
	}

	public function down()
	{
		Schema::drop('permissions');
	}
}