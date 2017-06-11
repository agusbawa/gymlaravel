<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagePricesTable extends Migration {

	public function up()
	{
		Schema::create('package_prices', function(Blueprint $table) {
			$table->increments('id');
			$table->bigInteger('package_id')->unsigned();
			$table->string('title', 100);
			$table->integer('month');
			$table->integer('price');
		});
	}

	public function down()
	{
		Schema::drop('package_prices');
	}
}