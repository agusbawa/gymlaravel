<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	public function up()
	{
		Schema::create('transactions', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('code', 100)->nullable()->index();
			$table->bigInteger('gym_id')->unsigned();
			$table->bigInteger('package_price_id')->unsigned();
			$table->bigInteger('member_id')->unsigned();
			$table->bigInteger('promo_id')->unsigned()->nullable();
			$table->string('status', 10);
			$table->string('type', 20);
			$table->string('payment_method', 100);
			$table->bigInteger('discount')->unsigned()->nullable();
			$table->bigInteger('total')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('transactions');
	}
}