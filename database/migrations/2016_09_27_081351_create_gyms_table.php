<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymsTable extends Migration {

	public function up()
	{
		Schema::create('gyms', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('title', 100);
			$table->text('address');
			$table->string('location_latitude', 20);
			$table->string('location_longitude', 20);
			$table->bigInteger('zona_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('gyms');
	}
}