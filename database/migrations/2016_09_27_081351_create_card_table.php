<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTable extends Migration {

	public function up()
	{
		Schema::create('cards', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('cards');
	}
}