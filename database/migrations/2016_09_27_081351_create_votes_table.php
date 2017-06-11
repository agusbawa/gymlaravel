<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

	public function up()
	{
		Schema::create('votes', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('title', 100);
			$table->text('description');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('votes');
	}
}