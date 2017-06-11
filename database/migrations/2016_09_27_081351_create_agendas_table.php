<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration {

	public function up()
	{
		Schema::create('agendas', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('title', 255);
			$table->date('date');
			$table->time('start_time');
			$table->time('end_time');
			$table->text('description');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('agendas');
	}
}