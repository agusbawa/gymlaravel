<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TargetGym extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('target_gym', function(Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('extends_per_month');
            $table->bigInteger('extends_per_month_price');
            $table->integer('returner');
            $table->bigInteger('returner_price');
            $table->integer('new_member');
            $table->bigInteger('new_member_price');
            $table->integer('harian');
            $table->integer('personal_trainer_id');
            $table->bigInteger('total');
            $table->bigInteger('target_omset');
            $table->integer('gym_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('target_gym');
    }
}
