<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('menu_histories',function(Blueprint $table){
            $table->increments('id');
            $table->integer('member_id');
            $table->dateTime('new_register');
            $table->dateTime('extends');
            $table->dateTime('expired');
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
        //
        Schema::Drop('menu_histories');
    }
}
