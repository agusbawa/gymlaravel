<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrainingSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 100);
            $table->date('tgl_training');
            $table->string('jam',10);
            $table->text('profile_trainer');
            $table->string('durasi',100);
            $table->bigInteger('gym_id')->unsigned();
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
        Schema::dropIfExists('training_schedule');
    }
}
