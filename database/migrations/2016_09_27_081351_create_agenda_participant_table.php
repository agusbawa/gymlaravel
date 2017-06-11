<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaParticipantTable extends Migration {

	public function up()
	{
		Schema::create('agenda_participant', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('agenda_id')->unsigned();
			$table->string('name', 50);
			$table->string('email', 100);
			$table->string('phone', 15);
			$table->text('address');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('agenda_participant');
	}
}