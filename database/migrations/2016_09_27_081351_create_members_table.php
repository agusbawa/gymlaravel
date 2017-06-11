<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	public function up()
	{
		Schema::create('members', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name', 100);
			$table->string('nick_name', 100);
			$table->string('slug', 100);
			$table->string('address_street', 100);
			$table->string('address_region', 100);
			$table->string('address_city', 100);
			$table->string('place_of_birth');
			$table->date('date_of_birth');
			$table->string('gender', 30);
			$table->string('phone', 15);
			$table->string('email', 100);
			$table->string('password');
			$table->string('facebook_url', 255);
			$table->string('twitter_url', 255);
			$table->string('instagram_url', 255);
			$table->string('hobby', 100);
			$table->string('job', 50);
			$table->string('status', 20);
			$table->bigInteger('package_id')->unsigned()->nullable();
			$table->bigInteger('gym_id')->unsigned();
			$table->datetime('extended_at')->nullable();
			$table->datetime('expired_at')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('members');
	}
}