<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteItemsTable extends Migration {

	public function up()
	{
		Schema::create('vote_items', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('vote_id')->unsigned();
			$table->string('title', 100);
			$table->text('description');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('vote_items');
	}
}