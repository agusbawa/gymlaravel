<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetoranBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setoran_bank', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank', 100);
            $table->string('rekening', 150);
            $table->integer('total');
            $table->datetime('tgl_stor');
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
        Schema::drop('setoran_bank');
    }
}
