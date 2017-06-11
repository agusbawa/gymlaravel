<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGymHarianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_harian', function(Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name', 100);
			$table->string('nick_name', 100);
                        $table->bigInteger('gym_id')->unsigned();
                        $table->bigInteger('package_id')->unsigned()->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('members_harian');
    }
}
