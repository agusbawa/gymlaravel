<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberVoteTable extends Migration {

	public function up()
	{
		Schema::create('member_vote', function(Blueprint $table) {
			$table->increments('id');
			$table->bigInteger('vote_item_id')->unsigned();
			$table->bigInteger('member_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('member_vote');
	}
}