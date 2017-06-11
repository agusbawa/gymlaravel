<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromosTable extends Migration {

	public function up()
	{
		Schema::create('promos', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('title', 100);
			$table->string('code', 30);
			$table->integer('qty');
			$table->datetime('start_date')->nullable();
			$table->datetime('end_date')->nullable();
			$table->integer('value');
			$table->string('unit', 50);
			$table->boolean('is_enabled');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('promos');
	}
}